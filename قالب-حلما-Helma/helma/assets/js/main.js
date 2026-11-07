/**
 * Helma Theme - Interactive Frontend Engine
 * Developer & Designer: علی فیروزی | شرکت هونا (hoonaco.ir)
 *
 * @package Helma
 */

document.addEventListener('DOMContentLoaded', function () {
    'use strict';

    // 1. Dark / Light Theme Mode Switcher with LocalStorage
    const themeToggleBtn = document.getElementById('helma-theme-toggle');
    const htmlElem = document.documentElement;

    function applyTheme(theme) {
        if (theme === 'light') {
            htmlElem.setAttribute('data-theme', 'light');
            if (themeToggleBtn) themeToggleBtn.innerHTML = '🌙';
        } else {
            htmlElem.removeAttribute('data-theme');
            if (themeToggleBtn) themeToggleBtn.innerHTML = '☀️';
        }
        localStorage.setItem('helma_theme', theme);
    }

    const savedTheme = localStorage.getItem('helma_theme') || 'dark';
    applyTheme(savedTheme);

    if (themeToggleBtn) {
        themeToggleBtn.addEventListener('click', function () {
            const current = htmlElem.getAttribute('data-theme') === 'light' ? 'light' : 'dark';
            const next = current === 'light' ? 'dark' : 'light';
            applyTheme(next);
        });
    }

    // 2. Interactive AI Prompt Simulator
    const promptInput = document.getElementById('prompt-input');
    const promptSubmitBtn = document.getElementById('prompt-submit-btn');
    const promptOutput = document.getElementById('prompt-output-content');
    const outputMetaTime = document.getElementById('output-meta-time');
    const outputMetaTokens = document.getElementById('output-meta-tokens');
    const quickChips = document.querySelectorAll('.chip-btn');

    const promptKnowledge = {
        'کد پایتون': {
            text: "def analyze_sentiment(text):\n    # مدل زبان اختصاصی حلما (Helma-Ultra-3)\n    tokens = tokenize_persian(text)\n    score = neural_engine.predict(tokens)\n    return f'تحلیل با موفقیت انجام شد: ضریب اطمینان ۹۹.۴٪ مثبت.'",
            time: '۲۸۰ms',
            tokens: '۷۴ t/s'
        },
        'استراتژی بازاریابی': {
            text: "استراتژی ۳ مرحله‌ای رشد مقیاس‌پذیر محصول SaaS:\n۱. لندینگ‌پیج فوق‌سریع با زمان لود زیر ۱ ثانیه و اثبات زنده کیفیت محصول.\n۲. تولید محتوای تخصصی و کیس‌استادی‌های واقعی در لینکدین و شبکه X.\n۳. آنبوردینگ بدون اصطکاک و خودکارسازی فرآیند خرید کاربر.",
            time: '۳۲۰ms',
            tokens: '۸۵ t/s'
        },
        'گزارش مالی': {
            text: "📊 خلاصه تحلیلی هوش مصنوعی برای گزارش فصلی هونا (hoonaco.ir):\n• نرخ رشد ماهانه (MRR): ۳۸٪ افزایش مستمر\n• شاخص سلامت سیستم و رضایت کاربران (CSAT): ۹۸.۶٪\n• بهینه‌سازی هزینه‌های زیرساخت ابری: کاهش ۴۲ درصدی با معماری ماژولار حلما.",
            time: '۳۶۰ms',
            tokens: '۹۱ t/s'
        }
    };

    let typingInterval = null;

    function runSimulator(promptText) {
        if (!promptOutput) return;

        let responseObj = promptKnowledge['کد پایتون'];
        if (promptText.includes('استراتژی') || promptText.includes('بازاریابی')) {
            responseObj = promptKnowledge['استراتژی بازاریابی'];
        } else if (promptText.includes('مالی') || promptText.includes('گزارش') || promptText.includes('هونا')) {
            responseObj = promptKnowledge['گزارش مالی'];
        }

        clearInterval(typingInterval);
        promptOutput.innerHTML = '<span class="simulator-cursor"></span>';
        if (outputMetaTime) outputMetaTime.textContent = 'در حال پردازش مدل...';
        if (outputMetaTokens) outputMetaTokens.textContent = '-- t/s';

        let charIndex = 0;
        const fullText = responseObj.text;

        typingInterval = setInterval(function () {
            if (charIndex < fullText.length) {
                const char = fullText.charAt(charIndex);
                const currentText = fullText.substring(0, charIndex + 1);
                promptOutput.innerHTML = currentText.replace(/\n/g, '<br>') + '<span class="simulator-cursor"></span>';
                charIndex++;
            } else {
                clearInterval(typingInterval);
                promptOutput.innerHTML = fullText.replace(/\n/g, '<br>');
                if (outputMetaTime) outputMetaTime.textContent = 'زمان پاسخ: ' + responseObj.time;
                if (outputMetaTokens) outputMetaTokens.textContent = 'نرخ تولید: ' + responseObj.tokens;
            }
        }, 18);
    }

    if (promptSubmitBtn && promptInput) {
        promptSubmitBtn.addEventListener('click', function () {
            const query = promptInput.value.trim() || 'کد پایتون برای پردازش زبان فارسی';
            runSimulator(query);
        });

        promptInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                promptSubmitBtn.click();
            }
        });
    }

    quickChips.forEach(function (chip) {
        chip.addEventListener('click', function () {
            const query = this.getAttribute('data-prompt') || this.textContent;
            if (promptInput) promptInput.value = query;
            runSimulator(query);
        });
    });

    // 3. Interactive Pricing Switcher (Monthly / Annual)
    const pricingToggle = document.getElementById('pricing-toggle');
    const priceAmounts = document.querySelectorAll('.price-val');
    const pricePeriods = document.querySelectorAll('.price-period');

    let isAnnual = false;

    if (pricingToggle) {
        pricingToggle.addEventListener('click', function () {
            isAnnual = !isAnnual;
            this.classList.toggle('active', isAnnual);

            priceAmounts.forEach(function (elem) {
                const monthlyPrice = elem.getAttribute('data-monthly');
                const annualPrice = elem.getAttribute('data-annual');
                elem.textContent = isAnnual ? annualPrice : monthlyPrice;
            });

            pricePeriods.forEach(function (elem) {
                elem.textContent = isAnnual ? '/ ماه (پرداخت سالانه با ۲۰٪ تخفیف)' : '/ ماهانه';
            });
        });
    }

    // 4. Interactive App Showcase Tabs
    const showcaseTabs = document.querySelectorAll('.showcase-tab-btn');
    const showcasePanes = document.querySelectorAll('.showcase-pane');

    showcaseTabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            const targetId = this.getAttribute('data-tab');
            showcaseTabs.forEach(function (t) { t.classList.remove('active'); });
            showcasePanes.forEach(function (p) { p.classList.remove('active'); });

            this.classList.add('active');
            const targetPane = document.getElementById(targetId);
            if (targetPane) targetPane.classList.add('active');
        });
    });

    // 5. Mobile Drawer Toggle
    const mobileToggle = document.getElementById('mobile-toggle');
    const mobileDrawer = document.getElementById('mobile-drawer-overlay');
    const closeDrawerBtn = document.getElementById('close-drawer-btn');

    if (mobileToggle && mobileDrawer) {
        mobileToggle.addEventListener('click', function () {
            mobileDrawer.classList.add('active');
        });
    }

    if (closeDrawerBtn && mobileDrawer) {
        closeDrawerBtn.addEventListener('click', function () {
            mobileDrawer.classList.remove('active');
        });
    }

    if (mobileDrawer) {
        mobileDrawer.addEventListener('click', function (e) {
            if (e.target === mobileDrawer) {
                mobileDrawer.classList.remove('active');
            }
        });
    }

});
