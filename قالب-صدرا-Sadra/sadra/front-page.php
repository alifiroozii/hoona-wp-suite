<?php
/**
 * صفحه اصلی پوسته آموزشی صدرا (Front Page)
 */
defined('ABSPATH') || exit;
get_header();

$opts = get_option('sadra_options', []);
$hero_title = !empty($opts['hero_title']) ? esc_html($opts['hero_title']) : 'مسیر حرفه‌ای یادگیری مهارت‌های روز دنیا';
$hero_sub   = !empty($opts['hero_subtitle']) ? esc_html($opts['hero_subtitle']) : 'بیش از ۵۰ دوره جامع تخصصی با تدریس برترین اساتید.';
?>

<main class="sadra-main">
    <!-- هیرو سکشن -->
    <section class="sadra-hero">
        <div class="sadra-hero-container">
            <div class="sadra-hero-content">
                <span class="sadra-pill-tag">🚀 ثبت‌نام ترم جدید با تخفیف ویژه آغاز شد</span>
                <h1 class="sadra-hero-title"><?php echo $hero_title; ?></h1>
                <p class="sadra-hero-desc"><?php echo $hero_sub; ?></p>
                <div class="sadra-hero-actions">
                    <a href="#courses" class="sadra-btn-primary">مشاهده لیست دوره‌ها</a>
                    <a href="#demo-player" class="sadra-btn-outline">🎥 تماشای نمونه ویدیو</a>
                </div>
            </div>

            <!-- آمار هیرو -->
            <div class="sadra-stats-grid">
                <div class="stat-card">
                    <span class="stat-number"><?php echo !empty($opts['stat_students']) ? esc_html($opts['stat_students']) : '+۱۲,۵۰۰'; ?></span>
                    <span class="stat-label">دانشجوی فعال</span>
                </div>
                <div class="stat-card">
                    <span class="stat-number"><?php echo !empty($opts['stat_courses']) ? esc_html($opts['stat_courses']) : '+۸۵'; ?></span>
                    <span class="stat-label">دوره تخصصی</span>
                </div>
                <div class="stat-card">
                    <span class="stat-number"><?php echo !empty($opts['stat_satisfy']) ? esc_html($opts['stat_satisfy']) : '۹۸.۴٪'; ?></span>
                    <span class="stat-label">رضایت دانشجویان</span>
                </div>
            </div>
        </div>
    </section>

    <!-- مزایای آموزش در صدرا -->
    <section class="sadra-features-bar">
        <div class="features-wrapper">
            <div class="feature-item">
                <span class="f-icon">🎯</span>
                <div>
                    <strong>پروژه‌محور و ورود به بازار کار</strong>
                    <p>آموزش مباحث کاربردی مورد نیاز کارفرمایان</p>
                </div>
            </div>
            <div class="feature-item">
                <span class="f-icon">💬</span>
                <div>
                    <strong>پشتیبانی مستقیم مدرس</strong>
                    <p>پاسخ به سوالات و رفع اشکال در تالار گفتگو</p>
                </div>
            </div>
            <div class="feature-item">
                <span class="f-icon">📜</span>
                <div>
                    <strong>گواهینامه پایان دوره معتبر</strong>
                    <p>امکان استعلام آنلاین مدرک جهت رزومه</p>
                </div>
            </div>
            <div class="feature-item">
                <span class="f-icon">♾️</span>
                <div>
                    <strong>دسترسی همیشگی به آپدیت‌ها</strong>
                    <p>دانلود و تماشای رایگان جلسات جدید</p>
                </div>
            </div>
        </div>
    </section>

    <!-- گرید دوره‌های آموزشی -->
    <section id="courses" class="sadra-courses-section">
        <div class="sadra-section-header">
            <span class="section-tag">دوره‌های منتخب</span>
            <h2>پرمخاطب‌ترین دوره‌های آکادمی صدرا</h2>
            <p>مهارت‌های کلیدی برای ورود سریع و تضمینی به بازار کار برنامه‌نویسی و فناوری</p>
        </div>

        <div class="sadra-courses-grid">
            <!-- دوره ۱ -->
            <article class="course-card">
                <div class="course-thumb">
                    <span class="course-badge">پرفروش</span>
                    <div class="course-thumb-placeholder" style="background: linear-gradient(135deg, #1e3a8a, #3b82f6);">🐍</div>
                </div>
                <div class="course-body">
                    <div class="course-meta">
                        <span>⏱️ ۶۵ ساعت</span>
                        <span>⭐ ۵.۰ (۱,۲۴۰ نظر)</span>
                    </div>
                    <h3>مسترکلاس جامع پایتون و یادگیری هوش مصنوعی</h3>
                    <p class="course-desc">از صفر مطلق تا ساخت چت‌بات‌های پیشرفته، پردازش تصویر و سیستم‌های اتوماسیون با پایتون.</p>
                    <div class="course-footer">
                        <div class="instructor">
                            <span class="avatar">ع‌ف</span>
                            <span>مهندس علی فیروزی</span>
                        </div>
                        <div class="price">
                            <strong>۹۵۰,۰۰۰ تومان</strong>
                        </div>
                    </div>
                </div>
            </article>

            <!-- دوره ۲ -->
            <article class="course-card">
                <div class="course-thumb">
                    <span class="course-badge" style="background:#10b981;">جدید</span>
                    <div class="course-thumb-placeholder" style="background: linear-gradient(135deg, #065f46, #10b981);">⚡</div>
                </div>
                <div class="course-body">
                    <div class="course-meta">
                        <span>⏱️ ۴۲ ساعت</span>
                        <span>⭐ ۴.۹ (۸۳۰ نظر)</span>
                    </div>
                    <h3>توسعه وب‌اپلیکیشن با React 19 و Next.js</h3>
                    <p class="course-desc">طراحی سایت‌های فوق‌سریع و اپلیکیشن‌های مقیاس‌پذیر با معماری مدرن فرانت‌اند.</p>
                    <div class="course-footer">
                        <div class="instructor">
                            <span class="avatar">س‌م</span>
                            <span>مهندس سهراب مرادی</span>
                        </div>
                        <div class="price">
                            <strong>۸۹۰,۰۰۰ تومان</strong>
                        </div>
                    </div>
                </div>
            </article>

            <!-- دوره ۳ -->
            <article class="course-card">
                <div class="course-thumb">
                    <div class="course-thumb-placeholder" style="background: linear-gradient(135deg, #581c87, #a855f7);">🎨</div>
                </div>
                <div class="course-body">
                    <div class="course-meta">
                        <span>⏱️ ۳۵ ساعت</span>
                        <span>⭐ ۴.۹ (۶۱۰ نظر)</span>
                    </div>
                    <h3>طراحی رابط و تجربه کاربری (UI/UX) با فیگما</h3>
                    <p class="course-desc">اصول دیزاین سیستم، تایپوگرافی، پروتوتایپ و خلق پروتکل‌های طراحی اپلیکیشن‌های موبایل.</p>
                    <div class="course-footer">
                        <div class="instructor">
                            <span class="avatar">ن‌ح</span>
                            <span>مهندس نیلوفر حبیبی</span>
                        </div>
                        <div class="price">
                            <strong>۷۵۰,۰۰۰ تومان</strong>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </section>

    <!-- پلیر ویدیوی تعاملی دوره -->
    <section id="demo-player" class="sadra-player-section">
        <div class="player-wrapper">
            <div class="player-main">
                <div class="video-container">
                    <div class="video-mockup">
                        <div class="play-overlay">
                            <div class="play-btn">▶</div>
                            <h4>جلسه اول: آشنایی با اکوسیستم هوش مصنوعی و مبانی مهندسی پرامپت</h4>
                            <span>کیفیت 1080p Full HD • حجم ۱۲۰ مگابایت</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="player-sidebar">
                <h3>سرفصل‌های آموزشی دوره</h3>
                <div class="lessons-list">
                    <div class="lesson-item active">
                        <span class="l-status">✓</span>
                        <div class="l-info">
                            <strong>فصل ۱: مقدمه و شروع کار</strong>
                            <small>۱۴ دقیقه • رایگان</small>
                        </div>
                    </div>
                    <div class="lesson-item">
                        <span class="l-status">🔒</span>
                        <div class="l-info">
                            <strong>فصل ۲: مفاهیم کلیدی و معماری</strong>
                            <small>۲۸ دقیقه • ویژه دانشجویان</small>
                        </div>
                    </div>
                    <div class="lesson-item">
                        <span class="l-status">🔒</span>
                        <div class="l-info">
                            <strong>فصل ۳: پیاده‌سازی پروژه عملی</strong>
                            <small>۴۵ دقیقه • ویژه دانشجویان</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
