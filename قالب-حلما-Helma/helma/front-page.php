<?php
/**
 * Helma Theme Front Page
 *
 * Developer & Designer: علی فیروزی | شرکت هونا (hoonaco.ir)
 *
 * @package Helma
 */

if (!defined('ABSPATH')) {
    exit('Direct access not permitted.');
}

get_header();
?>

<main id="primary" class="site-main">

    <!-- 1. HERO SECTION WITH LIVE AI PROMPT SIMULATOR -->
    <?php if (helma_opt('show_hero', 1)) : ?>
    <section class="hero-section" id="hero">
        <div class="container">
            
            <div class="hero-pill-badge">
                <span>⚡ نسخه ۳.۰ مدل اختصاصی حلما با دقت ۹۹.۴٪ منتشر شد</span>
            </div>

            <h1 class="hero-title">
                زیرساخت هوش مصنوعی و نرم‌افزارهای ابری<br>
                برای سریع‌ترین استارتاپ‌های پیشرو
            </h1>

            <p class="hero-subtitle">
                پوسته مدرن حلما استاندارد جدید محصولات دیجیتال است؛ معماری بنتو گرید، هدر معلق شیشه‌ای، سرعت لود زیر ۰.۸ ثانیه و تجربه کاربری همگام با برترین شرکت‌های فناوری جهان.
            </p>

            <div style="display:flex; justify-content:center; gap:1rem; margin-bottom:3.5rem; flex-wrap:wrap;">
                <a href="<?php echo esc_url(helma_opt('header_cta_url', '#pricing')); ?>" class="btn-primary-glow" style="padding:0.75rem 2rem; font-size:0.95rem;">
                    <?php echo esc_html(helma_opt('header_cta_text', 'شروع آزمایش رایگان')); ?> ←
                </a>
                <a href="#simulator" class="btn-primary-glow" style="background:rgba(255,255,255,0.06); border:1px solid var(--border-card); box-shadow:none; padding:0.75rem 1.75rem; font-size:0.95rem;">
                    تست زنده شبیه‌ساز AI ⚡
                </a>
            </div>

            <!-- LIVE AI PROMPT SIMULATOR COMPONENT -->
            <?php if (helma_opt('show_simulator', 1)) : ?>
            <div class="prompt-simulator-card" id="simulator">
                <div class="simulator-header">
                    <div class="simulator-controls">
                        <span class="simulator-dot dot-red"></span>
                        <span class="simulator-dot dot-yellow"></span>
                        <span class="simulator-dot dot-green"></span>
                    </div>
                    <div style="display:flex; align-items:center; gap:0.5rem;">
                        <span style="font-size:0.8rem; color:var(--text-dim);">پایانه تعاملی:</span>
                        <span class="simulator-model-pill"><?php echo esc_html(helma_opt('simulator_badge', 'Helma-Ultra-3.0')); ?></span>
                    </div>
                </div>

                <div class="simulator-body">
                    <!-- Input Row -->
                    <div class="simulator-input-box">
                        <input type="text" id="prompt-input" class="simulator-input" placeholder="<?php echo esc_attr(helma_opt('simulator_placeholder', 'یک دستور بنویسید (مثلاً: استراتژی بازاریابی، کد پایتون یا گزارش مالی)...')); ?>" value="کد پایتون برای تحلیل احساسات" />
                        <button type="button" id="prompt-submit-btn" class="simulator-btn">ارسال به مدل ←</button>
                    </div>

                    <!-- Quick Prompt Chips -->
                    <div class="quick-chips-wrap">
                        <span style="font-size:0.78rem; color:var(--text-dim);">پیشنهاد سریع:</span>
                        <button type="button" class="chip-btn" data-prompt="کد پایتون برای پردازش زبان طبیعی">🐍 کد پایتون</button>
                        <button type="button" class="chip-btn" data-prompt="استراتژی بازاریابی برای رشد محصول SaaS">🚀 استراتژی بازاریابی</button>
                        <button type="button" class="chip-btn" data-prompt="خلاصه‌سازی گزارش مالی فصلی شرکت هونا">📊 گزارش مالی هونا</button>
                    </div>

                    <!-- Live Output Terminal -->
                    <div class="simulator-output">
                        <div id="prompt-output-content">
                            def analyze_sentiment(text):<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;# مدل زبان اختصاصی حلما (Helma-Ultra-3)<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;tokens = tokenize_persian(text)<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;score = neural_engine.predict(tokens)<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;return f'تحلیل با موفقیت انجام شد: ضریب اطمینان ۹۹.۴٪ مثبت.'
                        </div>
                        <div class="output-meta">
                            <span id="output-meta-time">زمان پاسخ: ۲۸۰ms</span>
                            <span id="output-meta-tokens">نرخ تولید: ۷۴ t/s</span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </section>
    <?php endif; ?>

    <!-- 2. BENTO GRID 2.0 (FEATURES SHOWCASE) -->
    <?php if (helma_opt('show_bento', 1)) : ?>
    <section class="section" id="bento">
        <div class="container">
            
            <div class="section-title-wrap">
                <span class="section-badge">معماری بنتو گرید</span>
                <h2 class="section-title">قدرتی بی‌انتها، طراحی شده برای عملکرد فوق‌سریع</h2>
                <p class="section-desc">هر المان در حلما به دقت مهندسی شده تا بازدیدکننده معمولی را در ثانیه‌های نخست به کاربر وفادار تبدیل کند.</p>
            </div>

            <div class="bento-grid">
                
                <!-- Card 1: Processing Power (Span 8) -->
                <div class="bento-card bento-col-8">
                    <div class="bento-card-glow"></div>
                    <div class="bento-icon">⚡</div>
                    <h3 class="bento-title">استنتاج عصبی با تأخیر نزدیک به صفر</h3>
                    <p class="bento-desc">پردازش بلادرنگ درخواست‌ها با حافظه کش چندلایه و سرورهای توزیع‌شده ابری. سرعت لود قالب حتی روی هاست‌های اشتراکی ایران کمتر از ۰.۸ ثانیه است.</p>
                    <div class="code-preview-box">
                        <span style="color:#64748b;">// Helma Edge Pipeline Response</span><br>
                        <span style="color:#f43f5e;">const</span> response = <span style="color:#f43f5e;">await</span> helma.generate({<br>
                        &nbsp;&nbsp;prompt: <span style="color:#34d399;">"تحلیل وضعیت دیتابیس وردپرس"</span>,<br>
                        &nbsp;&nbsp;temperature: <span style="color:#f59e0b;">0.2</span>,<br>
                        &nbsp;&nbsp;securityShield: <span style="color:#38bdf8;">true</span><br>
                        });
                    </div>
                </div>

                <!-- Card 2: OWASP Shield (Span 4) -->
                <div class="bento-card bento-col-4">
                    <div class="bento-card-glow" style="background:radial-gradient(circle, rgba(16, 185, 129, 0.15) 0%, transparent 70%);"></div>
                    <div class="bento-icon" style="background:rgba(16, 185, 129, 0.12); border-color:rgba(16, 185, 129, 0.3);">🛡️</div>
                    <h3 class="bento-title">امنیت نفوذناپذیر OWASP</h3>
                    <p class="bento-desc">تزریق خودکار تمام هدرهای ایمنی CSP و HSTS، خنثی‌سازی اسکن نام کاربری مدیر و مسدودسازی پینگ‌بک‌های مخرب بدون نیاز به پلاگین‌های جانبی سنگین.</p>
                    <div style="margin-top:1.5rem; display:flex; align-items:center; gap:0.5rem; font-size:0.85rem; color:#34d399; font-weight:700;">
                        <span>✓ ضریب امنیت: ۱۰۰ / ۱۰۰</span>
                    </div>
                </div>

                <!-- Card 3: Connectors & Integrations (Span 4) -->
                <div class="bento-card bento-col-4">
                    <div class="bento-card-glow" style="background:radial-gradient(circle, rgba(6, 182, 212, 0.15) 0%, transparent 70%);"></div>
                    <div class="bento-icon" style="background:rgba(6, 182, 212, 0.12); border-color:rgba(6, 182, 212, 0.3);">🔌</div>
                    <h3 class="bento-title">یکپارچگی و اتصالات API</h3>
                    <p class="bento-desc">هماهنگی کامل با ربات‌های تلگرام، وب‌هوک‌های اختصاصی، ووکامرس، Zapier و تمام سرویس‌های پرداخت ایرانی و بین‌المللی.</p>
                    <div style="margin-top:1.25rem; display:flex; gap:0.6rem; flex-wrap:wrap;">
                        <span style="background:rgba(255,255,255,0.06); padding:3px 10px; border-radius:6px; font-size:0.75rem; color:var(--text-dim);">REST API</span>
                        <span style="background:rgba(255,255,255,0.06); padding:3px 10px; border-radius:6px; font-size:0.75rem; color:var(--text-dim);">Webhooks</span>
                        <span style="background:rgba(255,255,255,0.06); padding:3px 10px; border-radius:6px; font-size:0.75rem; color:var(--text-dim);">Telegram MiniApp</span>
                    </div>
                </div>

                <!-- Card 4: Analytics & Real-Time Metrics (Span 8) -->
                <div class="bento-card bento-col-8">
                    <div class="bento-card-glow"></div>
                    <div class="bento-icon">📊</div>
                    <h3 class="bento-title">تحلیل و ره‌گیری شاخص‌های کلیدی رشد</h3>
                    <p class="bento-desc">داشبورد هوشمند ثبت آمار بدون کاهش سرعت سایت. نظارت بر بازدیدهای یکتا، نرخ تبدیل ثبت‌نام‌ها و استفاده از توکن‌های هوش مصنوعی با نمودارهای چشم‌نواز.</p>
                    <div style="margin-top:1.5rem; background:var(--bg-surface-elevated); border:1px solid var(--border-subtle); border-radius:var(--radius-md); padding:1.25rem; display:grid; grid-template-columns:repeat(3, 1fr); gap:1rem; text-align:center;">
                        <div>
                            <div style="font-size:1.6rem; font-weight:800; color:var(--glow-primary);">+۲۴۸٪</div>
                            <div style="font-size:0.78rem; color:var(--text-dim);">رشد نرخ تبدیل لندینگ</div>
                        </div>
                        <div>
                            <div style="font-size:1.6rem; font-weight:800; color:var(--glow-secondary);">۰.۶۴s</div>
                            <div style="font-size:0.78rem; color:var(--text-dim);">میانگین سرعت لود صفحات</div>
                        </div>
                        <div>
                            <div style="font-size:1.6rem; font-weight:800; color:var(--glow-emerald);">۹۹.۹۸٪</div>
                            <div style="font-size:0.78rem; color:var(--text-dim);">پایداری و آپتایم سرور</div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>
    <?php endif; ?>

    <!-- 3. INTERACTIVE APP SHOWCASE TABS -->
    <?php if (helma_opt('show_showcase', 1)) : ?>
    <section class="section" id="showcase" style="background:rgba(255,255,255,0.01); border-top:1px solid var(--border-subtle); border-bottom:1px solid var(--border-subtle);">
        <div class="container">
            
            <div class="section-title-wrap">
                <span class="section-badge">محیط کاربری محصول</span>
                <h2 class="section-title">ویترین تعاملی نرم‌افزار و ابزارهای حلما</h2>
                <p class="section-desc">مشاهده پیش‌نمایش ماژول‌های مختلف سیستم بدون نیاز به رفرش یا بارگذاری مجدد صفحه.</p>
            </div>

            <!-- Tab Switcher -->
            <div class="showcase-tabs">
                <button type="button" class="showcase-tab-btn active" data-tab="pane-dashboard">📈 داشبورد تحلیلی و درآمد</button>
                <button type="button" class="showcase-tab-btn" data-tab="pane-chat">💬 دستیار چت و تولید محتوا</button>
                <button type="button" class="showcase-tab-btn" data-tab="pane-api">🔑 مدیریت کلیدهای API و مدل‌ها</button>
            </div>

            <!-- Window Showcase Box -->
            <div class="showcase-window">
                <div class="showcase-window-bar">
                    <div class="simulator-controls">
                        <span class="simulator-dot dot-red"></span>
                        <span class="simulator-dot dot-yellow"></span>
                        <span class="simulator-dot dot-green"></span>
                    </div>
                    <span style="font-size:0.8rem; color:var(--text-dim); font-family:monospace;">https://app.helma-cloud.ir/dashboard</span>
                    <span></span>
                </div>

                <!-- Pane 1: Dashboard -->
                <div class="showcase-pane active" id="pane-dashboard">
                    <div>
                        <span style="font-size:0.8rem; color:var(--glow-primary); font-weight:700;">ماژول آنالیتیکس زنده</span>
                        <h3 style="font-size:1.8rem; font-weight:800; margin:0.5rem 0 1rem; color:var(--text-main);">کنترل ۳۶۰ درجه درآمد، ترافیک و بازدهی هوش مصنوعی</h3>
                        <p style="color:var(--text-muted); font-size:0.92rem; line-height:1.8;">
                            تمامی تراکنش‌ها، تعداد توکن‌های مصرفی و گزارش‌های مالی با نمودارهای گرادیانی در اختیار شما قرار می‌گیرد. با یک نگاه نبض کسب‌وکار را در دست داشته باشید.
                        </p>
                    </div>
                    <div style="background:var(--bg-base); border:1px solid var(--border-card); border-radius:var(--radius-md); padding:1.5rem;">
                        <div style="display:flex; justify-content:space-between; margin-bottom:1rem; font-size:0.85rem;">
                            <span>درآمد هفتگی (MRR)</span>
                            <span style="color:#34d399; font-weight:700;">+۱۸.۴٪ رشد</span>
                        </div>
                        <div style="height:120px; display:flex; align-items:flex-end; gap:0.6rem; padding-top:1rem;">
                            <div style="flex:1; height:45%; background:rgba(139, 92, 246, 0.3); border-radius:4px;"></div>
                            <div style="flex:1; height:60%; background:rgba(139, 92, 246, 0.4); border-radius:4px;"></div>
                            <div style="flex:1; height:50%; background:rgba(139, 92, 246, 0.4); border-radius:4px;"></div>
                            <div style="flex:1; height:80%; background:rgba(139, 92, 246, 0.6); border-radius:4px;"></div>
                            <div style="flex:1; height:70%; background:rgba(139, 92, 246, 0.5); border-radius:4px;"></div>
                            <div style="flex:1; height:95%; background:var(--glow-primary); border-radius:4px; box-shadow:0 0 12px var(--glow-primary);"></div>
                        </div>
                    </div>
                </div>

                <!-- Pane 2: Chat Assistant -->
                <div class="showcase-pane" id="pane-chat">
                    <div>
                        <span style="font-size:0.8rem; color:var(--glow-secondary); font-weight:700;">دستیار هوشمند چت</span>
                        <h3 style="font-size:1.8rem; font-weight:800; margin:0.5rem 0 1rem; color:var(--text-main);">پاسخگویی به کاربران با زبان مادری و لحن برند شما</h3>
                        <p style="color:var(--text-muted); font-size:0.92rem; line-height:1.8;">
                            دستیار گفتگو با توانایی یادگیری از اسناد داخلی شرکت، مستندات محصولات و تاریخچه پاسخگویی برای پشتیبانی خودکار ۲۴ ساعته.
                        </p>
                    </div>
                    <div style="background:var(--bg-base); border:1px solid var(--border-card); border-radius:var(--radius-md); padding:1.5rem; display:flex; flex-direction:column; gap:0.85rem;">
                        <div style="background:var(--bg-surface); padding:0.75rem 1rem; border-radius:10px 10px 0 10px; font-size:0.85rem; max-width:85%; align-self:flex-start;">
                            سلام! چطور می‌تونم اکانت تیمی شرکت رو شارژ کنم؟
                        </div>
                        <div style="background:rgba(139, 92, 246, 0.15); border:1px solid rgba(139, 92, 246, 0.25); padding:0.75rem 1rem; border-radius:10px 10px 10px 0; font-size:0.85rem; max-width:90%; align-self:flex-end; color:#c4b5fd;">
                            درود بر شما! از منوی بالای داشبورد وارد تب «مدیریت پلن‌ها» شده و روی «افزودن صندلی سازمانی» کلیک فرمایید.
                        </div>
                    </div>
                </div>

                <!-- Pane 3: API Manager -->
                <div class="showcase-pane" id="pane-api">
                    <div>
                        <span style="font-size:0.8rem; color:var(--glow-emerald); font-weight:700;">مدیریت زیرساخت API</span>
                        <h3 style="font-size:1.8rem; font-weight:800; margin:0.5rem 0 1rem; color:var(--text-main);">صدور کلیدهای اختصاصی با محدودیت نرخ و امنیت کامل</h3>
                        <p style="color:var(--text-muted); font-size:0.92rem; line-height:1.8;">
                            دسترسی به وب‌سرویس‌های هوش مصنوعی با قابلیت تعیین سقف مصرف ماهانه، فیلتر دامنه و لاگ دقیق تک‌تک درخواست‌های ارسالی.
                        </p>
                    </div>
                    <div style="background:var(--bg-base); border:1px solid var(--border-card); border-radius:var(--radius-md); padding:1.5rem; font-family:monospace; font-size:0.8rem; direction:ltr; text-align:left;">
                        <span style="color:#94a3b8;">// API Endpoint Health</span><br>
                        POST /v1/chat/completions<br>
                        Authorization: Bearer sk-helma-****92f<br>
                        Status: <span style="color:#34d399;">200 OK</span> (Latency: 142ms)
                    </div>
                </div>

            </div>

        </div>
    </section>
    <?php endif; ?>

    <!-- 4. INTERACTIVE PRICING MATRIX -->
    <?php if (helma_opt('show_pricing', 1)) : ?>
    <section class="section" id="pricing">
        <div class="container">
            
            <div class="section-title-wrap">
                <span class="section-badge">پلن‌ها و تعرفه‌ها</span>
                <h2 class="section-title">سرمایه‌گذاری شفاف برای شروع و رشد پایدار</h2>
                <p class="section-desc">پلن مناسب را متناسب با اندازه تیم و حجم کاربران خود برگزینید.</p>
            </div>

            <!-- Pricing Switcher -->
            <div class="pricing-switch-wrap">
                <span>پرداخت ماهانه</span>
                <div class="pricing-toggle" id="pricing-toggle" aria-label="تغییر حالت پرداخت ماهانه و سالانه"></div>
                <span>پرداخت سالانه</span>
                <span class="pricing-discount-badge">۲۰٪ تخفیف ویژه</span>
            </div>

            <!-- Cards Grid -->
            <div class="pricing-grid">
                
                <!-- Plan 1: Starter -->
                <div class="pricing-card">
                    <div>
                        <div class="plan-name">استارتر (Starter)</div>
                        <div class="plan-desc">مناسب برای پروژه‌های نوپا و توسعه‌دهندگان مستقل</div>
                        <div class="plan-price-wrap">
                            <span class="plan-price price-val" data-monthly="<?php echo esc_attr(helma_opt('price_starter_mo', '۴۹۰,۰۰۰')); ?>" data-annual="<?php echo esc_attr(helma_opt('price_starter_yr', '۳۹۰,۰۰۰')); ?>">
                                <?php echo esc_html(helma_opt('price_starter_mo', '۴۹۰,۰۰۰')); ?>
                            </span>
                            <span style="font-size:0.9rem; color:var(--text-muted);">تومان</span>
                            <span class="plan-period price-period">/ ماهانه</span>
                        </div>
                        <ul class="plan-features">
                            <li class="feature-item"><span class="check-icon">✓</span> ۱۰۰,۰۰۰ توکن ماهانه مدل هوش مصنوعی</li>
                            <li class="feature-item"><span class="check-icon">✓</span> ۱ دامنه و وب‌سایت فعال</li>
                            <li class="feature-item"><span class="check-icon">✓</span> پشتیبانی استاندارد از طریق تیکت</li>
                            <li class="feature-item"><span class="check-icon">✓</span> لود سریع با زیرساخت Edge</li>
                        </ul>
                    </div>
                    <a href="#simulator" class="btn-primary-glow" style="background:var(--bg-surface-elevated); border:1px solid var(--border-card); box-shadow:none; justify-content:center;">
                        انتخاب پلن استارتر
                    </a>
                </div>

                <!-- Plan 2: Pro (Featured) -->
                <div class="pricing-card featured">
                    <span class="featured-pill">⭐ پیشنهاد منتخب هونا</span>
                    <div>
                        <div class="plan-name">حرفه‌ای (Pro Business)</div>
                        <div class="plan-desc">بهترین انتخاب برای استارتاپ‌ها و شرکت‌های در حال رشد</div>
                        <div class="plan-price-wrap">
                            <span class="plan-price price-val" data-monthly="<?php echo esc_attr(helma_opt('price_pro_mo', '۱,۴۹۰,۰۰۰')); ?>" data-annual="<?php echo esc_attr(helma_opt('price_pro_yr', '۱,۱۹۰,۰۰۰')); ?>">
                                <?php echo esc_html(helma_opt('price_pro_mo', '۱,۴۹۰,۰۰۰')); ?>
                            </span>
                            <span style="font-size:0.9rem; color:var(--text-muted);">تومان</span>
                            <span class="plan-period price-period">/ ماهانه</span>
                        </div>
                        <ul class="plan-features">
                            <li class="feature-item"><span class="check-icon">✓</span> ۵۰۰,۰۰۰ توکن پرسرعت ماهانه</li>
                            <li class="feature-item"><span class="check-icon">✓</span> ۵ دامنه و لندینگ نامحدود</li>
                            <li class="feature-item"><span class="check-icon">✓</span> شبیه‌ساز زنده پرامپت و ویترین تعاملی</li>
                            <li class="feature-item"><span class="check-icon">✓</span> پشتیبانی ۲۴ ساعته تلگرام و تیکت</li>
                            <li class="feature-item"><span class="check-icon">✓</span> دسترسی اختصاصی به وب‌هوک و API</li>
                        </ul>
                    </div>
                    <a href="#simulator" class="btn-primary-glow" style="justify-content:center;">
                        شروع با پلن حرفه‌ای ←
                    </a>
                </div>

                <!-- Plan 3: Enterprise -->
                <div class="pricing-card">
                    <div>
                        <div class="plan-name">سازمانی (Enterprise)</div>
                        <div class="plan-desc">برای پلتفرم‌های پربازدید، تیم‌های بزرگ و سازمان‌ها</div>
                        <div class="plan-price-wrap">
                            <span class="plan-price price-val" data-monthly="<?php echo esc_attr(helma_opt('price_ent_mo', '۳,۹۰۰,۰۰۰')); ?>" data-annual="<?php echo esc_attr(helma_opt('price_ent_yr', '۳,۱۲۰,۰۰۰')); ?>">
                                <?php echo esc_html(helma_opt('price_ent_mo', '۳,۹۰۰,۰۰۰')); ?>
                            </span>
                            <span style="font-size:0.9rem; color:var(--text-muted);">تومان</span>
                            <span class="plan-period price-period">/ ماهانه</span>
                        </div>
                        <ul class="plan-features">
                            <li class="feature-item"><span class="check-icon">✓</span> توکن و حجم پردازش نامحدود</li>
                            <li class="feature-item"><span class="check-icon">✓</span> زیرساخت اختصاصی بدون اشتراک ترافیک</li>
                            <li class="feature-item"><span class="check-icon">✓</span> قرارداد SLA آپتایم ۹۹.۹۹٪</li>
                            <li class="feature-item"><span class="check-icon">✓</span> مدیر فنی اختصاصی از شرکت هونا</li>
                        </ul>
                    </div>
                    <a href="https://hoonaco.ir" target="_blank" class="btn-primary-glow" style="background:var(--bg-surface-elevated); border:1px solid var(--border-card); box-shadow:none; justify-content:center;">
                        مشاوره سازمانی با هونا
                    </a>
                </div>

            </div>

        </div>
    </section>
    <?php endif; ?>

    <!-- 5. WALL OF LOVE / TESTIMONIALS -->
    <?php if (helma_opt('show_testimonials', 1)) : ?>
    <section class="section" id="testimonials" style="background:rgba(255,255,255,0.01); border-top:1px solid var(--border-subtle);">
        <div class="container">
            
            <div class="section-title-wrap">
                <span class="section-badge">دیوار رضایت و اعتماد</span>
                <h2 class="section-title">نظرات فعالان اکوسیستم و بنیان‌گذاران فناوری</h2>
                <p class="section-desc">ببینید متخصصان پس از تجربه لندینگ و پوسته حلما چه می‌گویند.</p>
            </div>

            <div class="testimonials-grid">
                
                <div class="testimonial-card">
                    <div class="testimonial-header">
                        <div class="avatar-ring"><div class="avatar-img">پ.ر</div></div>
                        <div>
                            <div class="author-name">پویا رضایی</div>
                            <div class="author-role">مدیر محصول استارتاپ هوش مصنوعی</div>
                        </div>
                    </div>
                    <div class="star-rating">★★★★★</div>
                    <p class="testimonial-quote">«پوسته حلما دقیقاً همون چیزی بود که ماه‌ها دنبالش بودیم؛ فوق‌العاده مدرن، بدون ذره‌ای کندی و با دیزاین بنتو که کاربران ما رو در اولین نگاه شیفته محصول کرد.»</p>
                </div>

                <div class="testimonial-card">
                    <div class="testimonial-header">
                        <div class="avatar-ring"><div class="avatar-img">س.م</div></div>
                        <div>
                            <div class="author-name">سارا محمدی</div>
                            <div class="author-role">توسعه‌دهنده ارشد فرانت‌اند</div>
                        </div>
                    </div>
                    <div class="star-rating">★★★★★</div>
                    <p class="testimonial-quote">«کیفیت کدنویسی علی فیروزی و رعایت دقیق اصول امنیت OWASP در پوسته حلما بی‌نظیره. لود سایت ما از ۴ ثانیه به زیر ۷۰۰ میلی‌ثانیه رسید!»</p>
                </div>

                <div class="testimonial-card">
                    <div class="testimonial-header">
                        <div class="avatar-ring"><div class="avatar-img">ع.ن</div></div>
                        <div>
                            <div class="author-name">علی ناصری</div>
                            <div class="author-role">هم‌بنیان‌گذار پلتفرم فین‌تک</div>
                        </div>
                    </div>
                    <div class="star-rating">★★★★★</div>
                    <p class="testimonial-quote">«شبیه‌ساز پرامپت توی هیرو نرخ تبدیل ثبت‌نام‌های ما رو ۲ برابر کرد. مخاطب درجا کیفیت سرویس رو تست می‌کنه و قانع به خرید می‌شه.»</p>
                </div>

            </div>

        </div>
    </section>
    <?php endif; ?>

    <!-- 6. BLOG & TECH NEWS -->
    <?php if (helma_opt('show_blog', 1)) : ?>
    <section class="section" id="blog">
        <div class="container">
            
            <div class="section-title-wrap">
                <span class="section-badge">دانش و نوآوری</span>
                <h2 class="section-title">آخرین مقالات و بینش‌های هوش مصنوعی</h2>
                <p class="section-desc">راهنماها و تحلیل‌های تخصصی درباره ترندهای فناوری و بهینه‌سازی وب.</p>
            </div>

            <div class="blog-grid">
                
                <article class="blog-card">
                    <div class="blog-thumb-placeholder">⚡</div>
                    <div class="blog-card-body">
                        <div>
                            <span class="blog-tag">مهندسی هوش مصنوعی</span>
                            <h3 class="blog-title">چگونه لندینگ‌پیج‌های مبتنی بر هوش مصنوعی نرخ تبدیل را دگرگون می‌کنند؟</h3>
                            <p class="blog-desc">تحلیل روانشناسی تعامل کاربر با شبیه‌سازهای زنده و ابزارهای تست تعاملی در نسل سوم وب.</p>
                        </div>
                        <div class="blog-footer">
                            <span>۴ دقیقه مطالعه</span>
                            <span style="color:var(--glow-primary); font-weight:700;">ادامه مطلب ←</span>
                        </div>
                    </div>
                </article>

                <article class="blog-card">
                    <div class="blog-thumb-placeholder" style="background:linear-gradient(135deg, #064e3b 0%, #0f172a 100%);">🛡️</div>
                    <div class="blog-card-body">
                        <div>
                            <span class="blog-tag" style="color:#34d399; background:rgba(16, 185, 129, 0.15);">امنیت وب (OWASP)</span>
                            <h3 class="blog-title">۱۰ آسیب‌پذیری بحرانی وردپرس و روش خنثی‌سازی آنها در سطح پوسته</h3>
                            <p class="blog-desc">راهنمای عملی مقاوم‌سازی سایت‌های ایرانی در برابر حملات تزریق و سرقت سشن‌ها.</p>
                        </div>
                        <div class="blog-footer">
                            <span>۶ دقیقه مطالعه</span>
                            <span style="color:var(--glow-primary); font-weight:700;">ادامه مطلب ←</span>
                        </div>
                    </div>
                </article>

                <article class="blog-card">
                    <div class="blog-thumb-placeholder" style="background:linear-gradient(135deg, #164e63 0%, #0f172a 100%);">🚀</div>
                    <div class="blog-card-body">
                        <div>
                            <span class="blog-tag" style="color:#38bdf8; background:rgba(6, 182, 212, 0.15);">معماری بنتو گرید</span>
                            <h3 class="blog-title">راز موفقیت زبان طراحی Bento Grid اپل در افزایش فروش محصولات SaaS</h3>
                            <p class="blog-desc">اصول چیدمان نامتقارن، سلسله‌مراتب بصری و ترکیب نورهای نئونی در جذب نگاه بازدیدکنندگان.</p>
                        </div>
                        <div class="blog-footer">
                            <span>۵ دقیقه مطالعه</span>
                            <span style="color:var(--glow-primary); font-weight:700;">ادامه مطلب ←</span>
                        </div>
                    </div>
                </article>

            </div>

        </div>
    </section>
    <?php endif; ?>

    <!-- 7. FINAL CTA BANNER -->
    <section class="section" style="padding-top:2rem;">
        <div class="container">
            <div style="background:linear-gradient(135deg, #1e1b4b 0%, #0f172a 100%); border:1px solid rgba(139, 92, 246, 0.4); border-radius:var(--radius-lg); padding:4rem 2rem; text-align:center; position:relative; overflow:hidden; box-shadow:var(--shadow-glow);">
                <div style="position:absolute; top:-100px; left:50%; transform:translateX(-50%); width:400px; height:200px; background:radial-gradient(circle, rgba(139, 92, 246, 0.3) 0%, transparent 70%); pointer-events:none;"></div>
                <h2 style="font-size:clamp(1.8rem, 4vw, 2.75rem); font-weight:800; color:#ffffff; margin-bottom:1rem; letter-spacing:-0.5px;">
                    آماده‌اید تجربه کاربری محصول خود را متحول کنید؟
                </h2>
                <p style="color:#cbd5e1; font-size:1.05rem; max-width:640px; margin:0 auto 2.5rem; line-height:1.8;">
                    همین حالا با پوسته قدرتمند حلما، سریع‌ترین و جذاب‌ترین لندینگ هوش مصنوعی و SaaS را راه‌اندازی کنید.
                </p>
                <div style="display:flex; justify-content:center; gap:1rem; flex-wrap:wrap;">
                    <a href="<?php echo esc_url(helma_opt('header_cta_url', '#pricing')); ?>" class="btn-primary-glow" style="padding:0.85rem 2.25rem; font-size:1rem;">
                        <?php echo esc_html(helma_opt('header_cta_text', 'شروع آزمایش رایگان')); ?> ←
                    </a>
                    <a href="https://hoonaco.ir" target="_blank" class="btn-primary-glow" style="background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.15); box-shadow:none; padding:0.85rem 2rem; font-size:1rem;">
                        ارتباط با تیم هونا ↗
                    </a>
                </div>
            </div>
        </div>
    </section>

</main>

<?php
get_footer();
