// main.js - GrowShop Theme & Interaction Engine

(() => {
  'use strict';

  // 1. Motor de Modo Oscuro / Claro
  const THEME_KEY = 'gs_theme';

  function getStoredTheme() {
    return localStorage.getItem(THEME_KEY);
  }

  function getPreferredTheme() {
    const stored = getStoredTheme();
    if (stored) return stored;
    return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
  }

  function applyTheme(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    document.documentElement.setAttribute('data-bs-theme', theme);
    
    // Actualizar meta theme-color para navegadores móviles
    const metaTheme = document.getElementById('metaThemeColor');
    if (metaTheme) {
      metaTheme.setAttribute('content', theme === 'dark' ? '#0c0f12' : '#f8fafc');
    }

    // Actualizar estado del botón en navbar si existe
    const toggleBtn = document.getElementById('themeToggleBtn');
    if (toggleBtn) {
      toggleBtn.setAttribute('data-active-theme', theme);
      toggleBtn.setAttribute('title', theme === 'dark' ? 'Cambiar a modo claro' : 'Cambiar a modo oscuro');
      toggleBtn.setAttribute('aria-label', theme === 'dark' ? 'Cambiar a modo claro' : 'Cambiar a modo oscuro');
    }

    window.dispatchEvent(new CustomEvent('gs:theme-change', { detail: { theme } }));
  }

  function toggleTheme() {
    const current = document.documentElement.getAttribute('data-theme') || getPreferredTheme();
    const next = current === 'dark' ? 'light' : 'dark';
    localStorage.setItem(THEME_KEY, next);
    applyTheme(next);
  }

  // Escuchar cambios del sistema operativo si no hay preferencia manual
  window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
    if (!getStoredTheme()) {
      applyTheme(e.matches ? 'dark' : 'light');
    }
  });

  document.addEventListener('DOMContentLoaded', () => {
    // Inicializar tema actual
    applyTheme(getPreferredTheme());

    // Enlazar botón de tema
    const toggleBtn = document.getElementById('themeToggleBtn');
    if (toggleBtn) {
      toggleBtn.addEventListener('click', toggleTheme);
    }

    // 2. Animaciones de revelado al hacer scroll (IntersectionObserver)
    const revealObserver = new IntersectionObserver((entries, obs) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          obs.unobserve(entry.target);
        }
      });
    }, { threshold: 0.12 });

    document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

    // 3. Navbar dinámico con efecto blur al hacer scroll
    const nav = document.querySelector('.gs-navbar');
    if (nav) {
      const handleScroll = () => {
        if (window.scrollY > 30) {
          nav.classList.add('scrolled');
        } else {
          nav.classList.remove('scrolled');
        }
      };
      window.addEventListener('scroll', handleScroll, { passive: true });
      handleScroll();
    }

    // 4. Scroll suave para enlaces internos
    document.addEventListener('click', e => {
      const link = e.target.closest('.scroll-link');
      if (link) {
        const href = link.getAttribute('href');
        if (href && href.startsWith('#')) {
          const target = document.querySelector(href);
          if (target) {
            e.preventDefault();
            const offset = 80;
            const top = target.getBoundingClientRect().top + window.pageYOffset - offset;
            window.scrollTo({ top, behavior: 'smooth' });
          }
        }
      }
    });
  });
})();