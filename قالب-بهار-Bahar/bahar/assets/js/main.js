/**
 * Bahar Theme - Enhanced Enterprise JavaScript (Refined Responsive)
 * Developer & Designer: علی فیروزی | شرکت هونا (hoonaco.ir)
 */
document.addEventListener('DOMContentLoaded', function () {
  'use strict';

  // 1. Theme Mode Switcher (Dark / Light) with LocalStorage persistence
  const themeToggleBtns = document.querySelectorAll('.theme-toggle-btn');
  const storedTheme = localStorage.getItem('bahar-theme') || 
                      (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');

  const applyTheme = (theme) => {
    if (theme === 'dark') {
      document.documentElement.setAttribute('data-theme', 'dark');
    } else {
      document.documentElement.removeAttribute('data-theme');
    }
    localStorage.setItem('bahar-theme', theme);
  };

  applyTheme(storedTheme);

  themeToggleBtns.forEach(btn => {
    btn.addEventListener('click', function () {
      const current = document.documentElement.getAttribute('data-theme') === 'dark' ? 'dark' : 'light';
      const nextTheme = current === 'dark' ? 'light' : 'dark';
      applyTheme(nextTheme);
    });
  });

  // 2. Reading Progress Bar
  const progressBar = document.querySelector('.reading-progress-bar');
  const articleContent = document.querySelector('.article-content');
  if (progressBar && articleContent) {
    const updateProgress = () => {
      const totalHeight = articleContent.offsetHeight;
      const visibleScrolled = window.scrollY - articleContent.offsetTop;
      const progress = Math.min(Math.max((visibleScrolled / totalHeight) * 100, 0), 100);
      progressBar.style.width = progress + '%';
    };
    window.addEventListener('scroll', updateProgress, { passive: true });
    updateProgress();
  }

  // 3. Sticky Header
  const header = document.querySelector('.site-header');
  if (header) {
    const handleScroll = () => {
      if (window.scrollY > 15) {
        header.classList.add('is-scrolled');
      } else {
        header.classList.remove('is-scrolled');
      }
    };
    window.addEventListener('scroll', handleScroll, { passive: true });
    handleScroll();
  }

  // 4. Mobile Drawer Toggle (Sleek Slide-over Panel)
  const mobileToggleBtn = document.querySelector('.mobile-menu-toggle');
  const mobileDrawer = document.querySelector('.mobile-drawer');
  const mobileBackdrop = document.querySelector('.mobile-drawer-backdrop');
  const mobileCloseBtn = document.querySelector('.mobile-drawer-close');

  const openDrawer = () => {
    if (mobileDrawer && mobileBackdrop) {
      mobileDrawer.classList.add('is-open');
      mobileBackdrop.classList.add('is-open');
      document.body.style.overflow = 'hidden';
    }
  };

  const closeDrawer = () => {
    if (mobileDrawer && mobileBackdrop) {
      mobileDrawer.classList.remove('is-open');
      mobileBackdrop.classList.remove('is-open');
      document.body.style.overflow = '';
    }
  };

  if (mobileToggleBtn) mobileToggleBtn.addEventListener('click', openDrawer);
  if (mobileCloseBtn) mobileCloseBtn.addEventListener('click', closeDrawer);
  if (mobileBackdrop) mobileBackdrop.addEventListener('click', closeDrawer);

  const drawerLinks = document.querySelectorAll('.mobile-drawer-menu a');
  drawerLinks.forEach(link => link.addEventListener('click', closeDrawer));

  // 5. Search Modal (Live Modal & Shortcut Ctrl+K / /)
  const searchModal = document.querySelector('.search-modal-backdrop');
  const searchTriggers = document.querySelectorAll('.search-trigger-btn');
  const searchCloseBtn = document.querySelector('.search-modal-close');
  const searchInput = document.querySelector('.search-modal-box input[type="search"]');

  const openSearch = () => {
    if (searchModal) {
      searchModal.classList.add('is-open');
      if (searchInput) {
        setTimeout(() => searchInput.focus(), 100);
      }
    }
  };

  const closeSearch = () => {
    if (searchModal) {
      searchModal.classList.remove('is-open');
    }
  };

  searchTriggers.forEach(btn => btn.addEventListener('click', openSearch));
  if (searchCloseBtn) searchCloseBtn.addEventListener('click', closeSearch);

  if (searchModal) {
    searchModal.addEventListener('click', function (e) {
      if (e.target === searchModal) closeSearch();
    });
  }

  document.addEventListener('keydown', function (e) {
    if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
      e.preventDefault();
      openSearch();
    } else if (e.key === 'Escape') {
      closeSearch();
      closeDrawer();
    }
  });

  // 6. FAQ Accordion Toggle
  const faqItems = document.querySelectorAll('.faq-item');
  faqItems.forEach(item => {
    const btn = item.querySelector('.faq-question');
    if (btn) {
      btn.addEventListener('click', () => {
        const isOpen = item.classList.contains('is-open');
        faqItems.forEach(other => {
          if (other !== item) {
            other.classList.remove('is-open');
            const otherBtn = other.querySelector('.faq-question');
            if (otherBtn) otherBtn.setAttribute('aria-expanded', 'false');
          }
        });
        item.classList.toggle('is-open', !isOpen);
        btn.setAttribute('aria-expanded', !isOpen ? 'true' : 'false');
      });
    }
  });

  // 7. Social Share Copy Link
  const copyBtns = document.querySelectorAll('.share-btn-copy');
  copyBtns.forEach(btn => {
    btn.addEventListener('click', function () {
      const url = window.location.href;
      navigator.clipboard.writeText(url).then(() => {
        const originalText = btn.innerHTML;
        btn.classList.add('copied');
        btn.innerHTML = '✓ لینک کپی شد!';
        setTimeout(() => {
          btn.classList.remove('copied');
          btn.innerHTML = originalText;
        }, 2200);
      }).catch(() => {
        alert('نشانی صفحه: ' + url);
      });
    });
  });

  // 8. Scroll To Top Button
  const scrollTopBtn = document.querySelector('.scroll-to-top');
  if (scrollTopBtn) {
    window.addEventListener('scroll', function () {
      if (window.scrollY > 400) {
        scrollTopBtn.classList.add('is-visible');
      } else {
        scrollTopBtn.classList.remove('is-visible');
      }
    }, { passive: true });

    scrollTopBtn.addEventListener('click', function () {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  // 9. Smooth Counter Animation for Stats
  const statNumbers = document.querySelectorAll('.stat-number[data-target]');
  if ('IntersectionObserver' in window && statNumbers.length > 0) {
    const observer = new IntersectionObserver((entries, obs) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const el = entry.target;
          const target = parseInt(el.getAttribute('data-target'), 10);
          const suffix = el.getAttribute('data-suffix') || '';
          if (!isNaN(target)) {
            let start = 0;
            const duration = 1600;
            const startTime = performance.now();
            const step = (now) => {
              const progress = Math.min((now - startTime) / duration, 1);
              const current = Math.floor(progress * target);
              el.textContent = current.toLocaleString('fa-IR') + suffix;
              if (progress < 1) {
                requestAnimationFrame(step);
              } else {
                el.textContent = target.toLocaleString('fa-IR') + suffix;
              }
            };
            requestAnimationFrame(step);
          }
          obs.unobserve(el);
        }
      });
    }, { threshold: 0.4 });

    statNumbers.forEach(el => observer.observe(el));
  }
});
