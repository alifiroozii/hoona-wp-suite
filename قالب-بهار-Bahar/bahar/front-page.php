<?php
/**
 * The template for displaying the front page (Enterprise Edition)
 *
 * Developer & Designer: علی فیروزی | شرکت هونا (hoonaco.ir)
 *
 * @package Bahar
 */

if (!defined('ABSPATH')) {
    exit('Direct access not permitted.');
}

get_header();
?>

<main id="primary" class="site-main">

    <!-- =========================================================
         1. Hero Section
         ========================================================= -->
    <?php if (bahar_opt('show_hero', 1)) : ?>
    <section class="hero-section">
        <div class="container hero-grid">
            
            <div class="hero-content">
                <div class="hero-badge">
                    <?php echo esc_html(bahar_opt('hero_badge', __('✨ نسخه ۱.۰ پوسته چندمنظوره بهار | شرکت هونا', 'bahar'))); ?>
                </div>

                <h1 class="hero-title">
                    <span class="hero-title-text"><?php echo esc_html(bahar_opt('hero_title', __('خلق تجربه دیجیتال مدرن، پرسرعت و امن', 'bahar'))); ?></span>
                </h1>

                <p class="hero-lead">
                    <?php echo esc_html(bahar_opt('hero_desc', __('طراحی و توسعه یافته توسط علی فیروزی در شرکت هونا (hoonaco.ir) با تمرکز بر امنیت نفوذناپذیر، سرعت لود زیر ۱ ثانیه و تایپوگرافی فارسی استاندارد.', 'bahar'))); ?>
                </p>

                <div class="hero-buttons">
                    <a href="#features" class="btn btn-primary btn-lg">
                        <?php echo esc_html__('مشاهده امکانات و خدمات', 'bahar'); ?>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </a>

                    <a href="https://hoonaco.ir" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-lg">
                        <?php echo esc_html__('درباره شرکت هونا', 'bahar'); ?>
                    </a>
                </div>

                <div class="hero-trust">
                    <div class="trust-avatars">
                        <div class="trust-avatar" style="background:#e0e7ff; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:12px; color:#3730a3;">ع‌ف</div>
                        <div class="trust-avatar" style="background:#dcfce7; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:12px; color:#166534;">هونا</div>
                        <div class="trust-avatar" style="background:#fef3c7; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:12px; color:#92400e;">امن</div>
                    </div>
                    <div class="trust-text">
                        <span>مورد اعتماد صدها کسب‌وکار و مشتریان شرکت هونا (hoonaco.ir)</span>
                    </div>
                </div>
            </div>

            <!-- Hero Visual Preview Card -->
            <div class="hero-visual">
                <div class="floating-badge badge-top">
                    <div style="width:10px; height:10px; border-radius:50%; background:#10b981; box-shadow:0 0 8px #10b981;"></div>
                    <span style="font-size:0.85rem; font-weight:600; color:var(--text-main);">امنیت سخت‌گیرانه (OWASP Ready)</span>
                </div>

                <div class="hero-card-preview">
                    <div class="hero-preview-topbar">
                        <div class="topbar-dots">
                            <span class="topbar-dot red"></span>
                            <span class="topbar-dot yellow"></span>
                            <span class="topbar-dot green"></span>
                        </div>
                        <span style="font-size:0.8rem; color:var(--text-muted); font-family:monospace;">hoonaco.ir/bahar</span>
                    </div>

                    <div class="hero-preview-content">
                        <div style="background:var(--color-primary-light); border:1px solid rgba(37,99,235,0.15); border-radius:var(--radius-md); padding:1.25rem;">
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:0.75rem;">
                                <span style="font-weight:700; color:var(--color-primary); font-size:0.95rem;">عملکرد فوق‌العاده پوسته</span>
                                <span style="font-size:0.75rem; background:rgba(37,99,235,0.2); color:var(--color-primary); padding:2px 8px; border-radius:10px; font-weight:600;">۹۹/۱۰۰</span>
                            </div>
                            <div style="width:100%; height:8px; background:rgba(37,99,235,0.2); border-radius:4px; overflow:hidden;">
                                <div style="width:98%; height:100%; background:var(--color-primary); border-radius:4px;"></div>
                            </div>
                        </div>

                        <div class="hero-metric-row">
                            <div class="metric-pill">
                                <span class="metric-pill-title">گواهینامه امنیت</span>
                                <span class="metric-pill-value" style="color:#059669;">تأیید شده</span>
                            </div>
                            <div class="metric-pill">
                                <span class="metric-pill-title">سرعت لودینگ</span>
                                <span class="metric-pill-value" style="color:var(--color-primary);">۰.۴ ثانیه</span>
                            </div>
                        </div>

                        <div style="background:var(--bg-muted); border:1px solid var(--border-light); padding:1rem; border-radius:var(--radius-md); display:flex; align-items:center; gap:0.75rem;">
                            <div style="width:36px; height:36px; border-radius:var(--radius-sm); background:var(--color-primary-light); color:var(--color-primary); display:flex; align-items:center; justify-content:center;">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </div>
                            <div>
                                <div style="font-weight:600; font-size:0.85rem; color:var(--text-main);">توسعه‌یافته توسط علی فیروزی</div>
                                <div style="font-size:0.75rem; color:var(--text-muted);">پشتیبانی و مهندسی شرکت هونا (hoonaco.ir)</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="floating-badge badge-bottom">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                    </svg>
                    <span style="font-size:0.85rem; font-weight:600; color:var(--text-main);">تایپوگرافی فارسی وزیرمتن توکار</span>
                </div>
            </div>

        </div>
    </section>
    <?php endif; ?>

    <!-- =========================================================
         2. Features / Services Grid
         ========================================================= -->
    <section class="section section-bg-muted" id="features">
        <div class="container">
            
            <div class="section-header">
                <span class="section-subtitle">امکانات و مزایای اختصاصی</span>
                <h2 class="section-title">چرا پوسته بهار انتخابی متمایز است؟</h2>
                <p class="section-desc">طراحی شده توسط شرکت هونا با تمرکز بر بالاترین استانداردهای امنیتی، سرعت بارگذاری و سادگی مدیریت محتوا.</p>
            </div>

            <div class="features-grid">
                
                <div class="feature-card">
                    <div class="feature-icon-wrapper" style="background:#fee2e2; color:#dc2626;">
                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        </svg>
                    </div>
                    <h3 class="feature-title">امنیت سخت‌گیرانه (Hardened)</h3>
                    <p class="feature-desc">مجهز به هدرهای امنیتی مدرن (HSTS, X-Frame, MIME)، مسدودسازی اتک‌های XML-RPC Pingback و جلوگیری از استخراج یوزرنیم مدیران.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon-wrapper">
                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                        </svg>
                    </div>
                    <h3 class="feature-title">سرعت خارق‌العاده و سبک</h3>
                    <p class="feature-desc">فاقد هرگونه اسکریپت سنگین اضافه؛ لود صفحات زیر ۱ ثانیه با بالاترین نمره در آزمون‌های بین‌المللی Google PageSpeed.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon-wrapper" style="background:#ccfbf1; color:#0d9488;">
                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 20h9"></path>
                            <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                        </svg>
                    </div>
                    <h3 class="feature-title">پنل سفارشی‌ساز زنده</h3>
                    <p class="feature-desc">تغییر رنگ‌ها، لوگو، متن‌های هیرو و تنظیمات فوتر به صورت آنی در پیشخوان وردپرس بدون نیاز به دانش برنامه‌نویسی.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon-wrapper" style="background:#fef3c7; color:#d97706;">
                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="2" y1="12" x2="22" y2="12"></line>
                            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                        </svg>
                    </div>
                    <h3 class="feature-title">راست‌چین و فونت وزیرمتن</h3>
                    <p class="feature-desc">پشتیبانی کامل و استاندارد از زبان فارسی با فونت بهینه‌سازی‌شده وزیرمتن به شکل فایل‌های لوکال بدون وابستگی به CDN خارجی.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon-wrapper" style="background:#ede9fe; color:#7c3aed;">
                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                            <line x1="8" y1="21" x2="16" y2="21"></line>
                            <line x1="12" y1="17" x2="12" y2="21"></line>
                        </svg>
                    </div>
                    <h3 class="feature-title">حالت شب و روز هوشمند</h3>
                    <p class="feature-desc">قابلیت سوئیچ آنی میان تم تیره و روشن (Dark / Light) همراه با ذخیره خودکار انتخاب کاربر در حافظه مرورگر.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon-wrapper" style="background:#dbeafe; color:#2563eb;">
                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                        </svg>
                    </div>
                    <h3 class="feature-title">سئو تکنیکال و Schema</h3>
                    <p class="feature-desc">ساختار نشانه‌گذاری معنایی HTML5، سرتیترهای استاندارد سئو و سرعت ایندکس عالی در موتور جستجوی گوگل.</p>
                </div>

            </div>

        </div>
    </section>

    <!-- =========================================================
         3. About / Split Section
         ========================================================= -->
    <section class="section" id="about">
        <div class="container split-grid">
            
            <div class="split-content">
                <span class="section-subtitle">درباره شرکت هونا</span>
                <h2 class="section-title">نوآوری در مهندسی وب و طراحی نرم‌افزار</h2>
                <p>پوسته بهار حاصل تجربه و دانش فنی <strong>علی فیروزی</strong> در <strong>شرکت هونا (hoonaco.ir)</strong> است. این محصول با ترکیب استانداردهای روز جهانی، ظاهری پاک و دلنشین و پروتکل‌های ضد نفوذ ساخته شده است.</p>

                <div class="check-list">
                    <div class="check-item">
                        <div class="check-icon">✓</div>
                        <span>رعایت کامل الزامات امنیتی OWASP و فیلتر ورودی‌ها و خروجی‌ها</span>
                    </div>
                    <div class="check-item">
                        <div class="check-icon">✓</div>
                        <span>شخصی‌سازی آنی رنگ‌ها و متون برند در پیشخوان وردپرس</span>
                    </div>
                    <div class="check-item">
                        <div class="check-icon">✓</div>
                        <span>فونت فارسی لوکال و بدون قطعی در سرورهای داخلی</span>
                    </div>
                    <div class="check-item">
                        <div class="check-icon">✓</div>
                        <span>کدنویسی تمیز با قابلیت توسعه ماژولار و سئو فرندلی</span>
                    </div>
                </div>

                <a href="https://hoonaco.ir" target="_blank" rel="noopener noreferrer" class="btn btn-primary">
                    ورود به وب‌سایت رسمی هونا (hoonaco.ir)
                </a>
            </div>

            <div class="split-visual" style="background:linear-gradient(135deg, var(--bg-muted) 0%, var(--bg-subtle) 100%); border:1px solid var(--border-light); border-radius:var(--radius-xl); padding:3rem 2.5rem; box-shadow:var(--shadow-sm);">
                <h3 style="font-size:1.5rem; font-weight:800; margin-bottom:1.5rem; color:var(--text-main);">شاخص‌های امنیتی و فنی</h3>
                
                <div style="display:flex; flex-direction:column; gap:1.75rem;">
                    <div>
                        <div style="display:flex; justify-content:space-between; margin-bottom:0.5rem; font-weight:600; font-size:0.9rem;">
                            <span>امتیاز امنیت و عدم آسیب‌پذیری</span>
                            <span style="color:#059669;">۱۰۰%</span>
                        </div>
                        <div style="width:100%; height:8px; background:#e2e8f0; border-radius:4px; overflow:hidden;">
                            <div style="width:100%; height:100%; background:#059669;"></div>
                        </div>
                    </div>

                    <div>
                        <div style="display:flex; justify-content:space-between; margin-bottom:0.5rem; font-weight:600; font-size:0.9rem;">
                            <span>بهینه‌سازی و انطباق با هسته وردپرس</span>
                            <span style="color:var(--color-primary);">۵.۸ تا ۶.۷+</span>
                        </div>
                        <div style="width:100%; height:8px; background:#e2e8f0; border-radius:4px; overflow:hidden;">
                            <div style="width:98%; height:100%; background:var(--color-primary);"></div>
                        </div>
                    </div>

                    <div>
                        <div style="display:flex; justify-content:space-between; margin-bottom:0.5rem; font-weight:600; font-size:0.9rem;">
                            <span>استاندارد دسترس‌پذیری وب (a11y)</span>
                            <span style="color:#d97706;">Grade A+</span>
                        </div>
                        <div style="width:100%; height:8px; background:#e2e8f0; border-radius:4px; overflow:hidden;">
                            <div style="width:95%; height:100%; background:#d97706;"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="container">
            <div class="stats-strip">
                <div class="stat-item">
                    <span class="stat-number" data-target="100" data-suffix="%">۱۰۰%</span>
                    <span class="stat-label">امنیت تضمین شده با هدرهای ایمن</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number" data-target="99" data-suffix="/100">۹۹</span>
                    <span class="stat-label">امتیاز عملکرد لایت‌هاوس</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number" data-target="24" data-suffix="/7">۲۴/۷</span>
                    <span class="stat-label">پشتیبانی تیم هونا (hoonaco.ir)</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number" data-target="1" data-suffix="کلیک">۱</span>
                    <span class="stat-label">نصب سریع در پیشخوان وردپرس</span>
                </div>
            </div>
        </div>
    </section>

    <!-- =========================================================
         4. Testimonials Section
         ========================================================= -->
    <?php if (bahar_opt('show_testimonials', 1)) : ?>
    <section class="section section-bg-muted" id="testimonials">
        <div class="container">
            <div class="section-header">
                <span class="section-subtitle">اعتماد شما، افتخار ماست</span>
                <h2 class="section-title">دیدگاه مدیران و مشتریان شرکت هونا</h2>
                <p class="section-desc">آنچه سازمان‌ها و استارتاپ‌های پیشرو درباره پایداری و کیفیت محصولات ما می‌گویند.</p>
            </div>

            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <div>
                        <div class="testimonial-rating">★★★★★</div>
                        <p class="testimonial-quote">«پوسته بهار سرعت سایت ما را دگرگون کرد. قبلاً لود سایتمان بالای ۴ ثانیه بود و حالا در کمتر از ۰.۵ ثانیه لود می‌شود. پشتیبانی تیم هونا واقعاً بی‌نظیر است.»</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">م‌ر</div>
                        <div>
                            <div class="testimonial-author-name">مهندس رضا محمدی</div>
                            <div class="testimonial-author-role">مدیر فنی استارتاپ تک‌نو</div>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card">
                    <div>
                        <div class="testimonial-rating">★★★★★</div>
                        <p class="testimonial-quote">«امنیت بالای این پوسته و عدم افشای نسخه وردپرس خیال ما را از بابت اسکنرهای امنیتی کاملاً راحت کرد. طراحی فارسی و فونت وزیرمتن آن بسیار چشم‌نواز است.»</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar" style="background:linear-gradient(135deg, #0d9488 0%, #10b981 100%);">س‌ح</div>
                        <div>
                            <div class="testimonial-author-name">سارا حسینی</div>
                            <div class="testimonial-author-role">مدیر بازاریابی دیجیتال</div>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card">
                    <div>
                        <div class="testimonial-rating">★★★★★</div>
                        <p class="testimonial-quote">«تغییر رنگ‌ها و تنظیمات هدر در سفارشی‌ساز وردپرس در چند دقیقه انجام شد. بعد از سال‌ها کار با پوسته‌های سنگین و باگی، بهار یک تجربه ناب و خالص بود.»</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar" style="background:linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">ع‌ک</div>
                        <div>
                            <div class="testimonial-author-name">علی کریمی</div>
                            <div class="testimonial-author-role">بنیان‌گذار آژانس وب‌نما</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- =========================================================
         5. Pricing Tables Section
         ========================================================= -->
    <?php if (bahar_opt('show_pricing', 1)) : ?>
    <section class="section" id="pricing">
        <div class="container">
            <div class="section-header">
                <span class="section-subtitle">سرمایه‌گذاری شفاف</span>
                <h2 class="section-title">پلن‌های همکاری و تعرفه‌های خدماتی</h2>
                <p class="section-desc">پلن مورد نظر خود را متناسب با وسعت کسب‌وکار خود انتخاب کنید.</p>
            </div>

            <div class="pricing-grid">
                
                <!-- Plan 1 -->
                <div class="pricing-card">
                    <h3 class="pricing-name">پلن استارتاپ</h3>
                    <p class="pricing-desc">مناسب برای کسب‌وکارهای نوپا، وبلاگ‌های شخصی و معرفی اولیه خدمات.</p>
                    <div class="pricing-price-wrap">
                        <span class="pricing-price">۳,۵۰۰,۰۰۰</span>
                        <span class="pricing-currency">تومان</span>
                        <span class="pricing-period">/ سالانه</span>
                    </div>
                    <div class="pricing-features-list">
                        <div class="pricing-feature-item">
                            <span class="pricing-feature-icon check">✓</span>
                            <span>قالب اختصاصی بهار با فونت وزیرمتن</span>
                        </div>
                        <div class="pricing-feature-item">
                            <span class="pricing-feature-icon check">✓</span>
                            <span>طراحی ۱۰۰% واکنش‌گرا و سریع</span>
                        </div>
                        <div class="pricing-feature-item">
                            <span class="pricing-feature-icon check">✓</span>
                            <span>پشتیبانی فنی ۶ ماهه هونا</span>
                        </div>
                        <div class="pricing-feature-item">
                            <span class="pricing-feature-icon cross">✕</span>
                            <span>شخصی‌سازی پیشرفته و اختصاصی</span>
                        </div>
                    </div>
                    <a href="#contact" class="btn btn-secondary">سفارش پلن استارتاپ</a>
                </div>

                <!-- Plan 2 (Featured) -->
                <div class="pricing-card featured">
                    <span class="pricing-popular-pill">پیشنهاد ویژه هونا</span>
                    <h3 class="pricing-name">پلن حرفه‌ای (سازمانی)</h3>
                    <p class="pricing-desc">ایده‌آل برای شرکت‌های در حال رشد، فروشگاه‌ها و برندهای معتبر با بالاترین نیاز امنیتی.</p>
                    <div class="pricing-price-wrap">
                        <span class="pricing-price">۷,۹۰۰,۰۰۰</span>
                        <span class="pricing-currency">تومان</span>
                        <span class="pricing-period">/ سالانه</span>
                    </div>
                    <div class="pricing-features-list">
                        <div class="pricing-feature-item">
                            <span class="pricing-feature-icon check">✓</span>
                            <span>تمام امکانات پلن استارتاپ</span>
                        </div>
                        <div class="pricing-feature-item">
                            <span class="pricing-feature-icon check">✓</span>
                            <span>پکیج امنیت سخت‌گیرانه OWASP + ضد دیداس</span>
                        </div>
                        <div class="pricing-feature-item">
                            <span class="pricing-feature-icon check">✓</span>
                            <span>حالت شب و روز هوشمند (Dark/Light Mode)</span>
                        </div>
                        <div class="pricing-feature-item">
                            <span class="pricing-feature-icon check">✓</span>
                            <span>پشتیبانی اختصاصی VIP یک‌ساله</span>
                        </div>
                    </div>
                    <a href="#contact" class="btn btn-primary">انتخاب پلن حرفه‌ای</a>
                </div>

                <!-- Plan 3 -->
                <div class="pricing-card">
                    <h3 class="pricing-name">پلن اینترپرایز (اختصاصی)</h3>
                    <p class="pricing-desc">برای هلدینگ‌ها و پلتفرم‌های پربازدید با نیازمندی‌های سفارشی و معماری ابری.</p>
                    <div class="pricing-price-wrap">
                        <span class="pricing-price">تماس</span>
                        <span class="pricing-currency">بگیرید</span>
                    </div>
                    <div class="pricing-features-list">
                        <div class="pricing-feature-item">
                            <span class="pricing-feature-icon check">✓</span>
                            <span>طراحی ماژول‌های اختصاصی بر پایه API</span>
                        </div>
                        <div class="pricing-feature-item">
                            <span class="pricing-feature-icon check">✓</span>
                            <span>مشاوره سئو و پرفورمنس اختصاصی</span>
                        </div>
                        <div class="pricing-feature-item">
                            <span class="pricing-feature-icon check">✓</span>
                            <span>تست نفوذ و ارزیابی امنیتی دوره‌ای</span>
                        </div>
                        <div class="pricing-feature-item">
                            <span class="pricing-feature-icon check">✓</span>
                            <span>مدیر پروژه اختصاصی از شرکت هونا</span>
                        </div>
                    </div>
                    <a href="https://hoonaco.ir" target="_blank" rel="noopener noreferrer" class="btn btn-secondary">مشاوره اختصاصی</a>
                </div>

            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- =========================================================
         6. FAQ Accordion Section
         ========================================================= -->
    <?php if (bahar_opt('show_faq', 1)) : ?>
    <section class="section section-bg-muted" id="faq">
        <div class="container">
            <div class="section-header">
                <span class="section-subtitle">پاسخ به سوالات شما</span>
                <h2 class="section-title">پرسش‌های متداول درباره پوسته بهار</h2>
                <p class="section-desc">پاسخ به پرتکرارترین سوالات کاربران پیرامون نصب، امنیت و شخصی‌سازی پوسته.</p>
            </div>

            <div class="faq-accordion">
                
                <div class="faq-item is-open">
                    <button class="faq-question" aria-expanded="true">
                        <span>آیا برای کار با این پوسته به کدنویسی نیاز دارم؟</span>
                        <span class="faq-icon-arrow">▼</span>
                    </button>
                    <div class="faq-answer">
                        خیر، هیچ‌گونه نیازی به دانش کدنویسی ندارید. تمام امکانات از جمله تغییر رنگ‌ها، فونت، متن‌های هیرو، دکمه‌ها و لوگو از طریق بخش «نمایش ← سفارشی‌سازی» در پیشخوان وردپرس به صورت کاملاً گرافیکی و با پیش‌نمایش آنی قابل تنظیم است.
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question" aria-expanded="false">
                        <span>آیا فونت وزیرمتن با قطعی اینترنت بین‌الملل دچار مشکل می‌شود؟</span>
                        <span class="faq-icon-arrow">▼</span>
                    </button>
                    <div class="faq-answer">
                        خیر. فونت استاندارد وزیرمتن (Vazirmatn) مستقیماً داخل پوشه قالب به صورت محلی و با فرمت فوق‌سریع WOFF2 قرار داده شده است و هیچ ارتباطی با CDNهای خارجی مانند گوگل‌فونت ندارد؛ در نتیجه در سرورهای داخلی و حالت آفلاین نیز با سرعت ۱۰۰٪ لود می‌شود.
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question" aria-expanded="false">
                        <span>امنیت قالب چگونه تضمین شده است؟</span>
                        <span class="faq-icon-arrow">▼</span>
                    </button>
                    <div class="faq-answer">
                        پوسته بهار دارای سیستم دفاعی ۶ لایه شامل مسدودسازی اتک‌های XML-RPC Pingback، جلوگیری از استخراج یوزرنیم مدیران (User Enumeration)، حذف ردپای نسخه وردپرس، تزریق هدرهای X-Frame-Options و MIME-Sniffing، و فیلتر سخت‌گیرانه ورودی‌ها مطابق استانداردهای OWASP است.
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question" aria-expanded="false">
                        <span>چگونه می‌توانم حالت تاریک (Dark Mode) را تنظیم کنم؟</span>
                        <span class="faq-icon-arrow">▼</span>
                    </button>
                    <div class="faq-answer">
                        دکمه خورشید و ماه در هدر بالای سایت قرار گرفته است. کاربر با یک کلیک می‌تواند بین حالت روشن و تیره سوئیچ کند. پوسته به صورت خودکار انتخاب کاربر را در حافظه مرورگر ذخیره می‌کند تا در دفعات بعدی نیز با همان تم باز شود.
                    </div>
                </div>

            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- =========================================================
         7. Latest Blog Posts
         ========================================================= -->
    <section class="section" id="blog">
        <div class="container">
            
            <div class="section-header">
                <span class="section-subtitle">وبلاگ و مقالات آموزشی</span>
                <h2 class="section-title">آخرین بینش‌ها و مطالب خواندنی</h2>
                <p class="section-desc">جدیدترین مقالات در زمینه توسعه وب، امنیت و برندینگ را دنبال کنید.</p>
            </div>

            <div class="posts-grid">
                <?php
                $recent_posts = new WP_Query(array(
                    'posts_per_page'      => 3,
                    'post_status'         => 'publish',
                    'ignore_sticky_posts' => 1,
                ));

                if ($recent_posts->have_posts()) :
                    while ($recent_posts->have_posts()) :
                        $recent_posts->the_post();
                        get_template_part('template-parts/content');
                    endwhile;
                    wp_reset_postdata();
                else :
                    for ($k = 1; $k <= 3; $k++) :
                        ?>
                        <article class="post-card">
                            <div class="post-thumbnail-wrap">
                                <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg, #eff6ff 0%, #f1f5f9 100%);color:var(--color-primary);">
                                    <svg width="42" height="42" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                        <polyline points="21 15 16 10 5 21"></polyline>
                                    </svg>
                                </div>
                            </div>
                            <div class="post-card-body">
                                <div class="post-meta-top">
                                    <span class="post-category-tag">امنیت و توسعه</span>
                                    <span>نوشته نمونه <?php echo esc_html($k); ?></span>
                                    <span class="meta-dot">•</span>
                                    <span>۳ دقیقه مطالعه</span>
                                </div>
                                <h3 class="post-card-title">
                                    <a href="#">چگونه امنیت سایت وردپرسی خود را به سطح سازمان‌های بزرگ ارتقا دهیم؟</a>
                                </h3>
                                <div class="post-card-excerpt">
                                    <p>بررسی اصول هاردنینگ وردپرس، بستن درگاه‌های آسیب‌پذیری و نقش هدرهای امنیتی در پیشگیری از نفوذ سایبری...</p>
                                </div>
                                <div class="post-card-footer">
                                    <div class="post-author">
                                        <span>علی فیروزی</span>
                                    </div>
                                    <span class="read-more-link">مطالعه مقاله ←</span>
                                </div>
                            </div>
                        </article>
                        <?php
                    endfor;
                endif;
                ?>
            </div>

        </div>
    </section>

    <!-- =========================================================
         8. CTA Banner Section
         ========================================================= -->
    <section class="section" id="contact" style="padding-bottom: 2rem;">
        <div class="container">
            <div class="cta-banner">
                <h2 class="cta-title">آماده همکاری با شرکت هونا هستید؟</h2>
                <p class="cta-desc">پوسته بهار را همین حالا روی وب‌سایت خود نصب کنید یا برای طراحی اختصاصی با ما تماس بگیرید.</p>
                <div style="display:flex; justify-content:center; gap:1rem; flex-wrap:wrap;">
                    <a href="https://hoonaco.ir" target="_blank" rel="noopener noreferrer" class="btn btn-primary btn-lg">
                        ارتباط با هونا (hoonaco.ir)
                    </a>
                </div>
            </div>
        </div>
    </section>

</main>

<?php
get_footer();
