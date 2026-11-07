<?php
/**
 * صفحه اصلی پوسته آگهی و املاک امین (Front Page)
 */
defined('ABSPATH') || exit;
get_header();

$opts = get_option('amin_options', []);
$hero_heading = !empty($opts['hero_heading']) ? esc_html($opts['hero_heading']) : 'جستجو و ثبت رایگان آگهی ملک در سراسر ایران';
?>

<main class="amin-main">
    <!-- بخش سرچ باکس هیرو -->
    <section class="amin-hero-search">
        <div class="amin-hero-container">
            <h1><?php echo $hero_heading; ?></h1>
            <p>هزاران فایل کارشناسی‌شده و آگهی مستقیم از مالکان بدون واسطه</p>

            <div class="search-filter-card">
                <div class="search-tabs">
                    <button type="button" class="s-tab active" data-type="buy">خرید و فروش</button>
                    <button type="button" class="s-tab" data-type="rent">رهن و اجاره</button>
                </div>
                <div class="search-fields-grid">
                    <div class="field-item">
                        <label>شهر و منطقه</label>
                        <select id="filter-city">
                            <option value="all">همه شهرها</option>
                            <option value="tehran" selected>تهران (سعادت‌آباد، نیاوران، ونک...)</option>
                            <option value="mashhad">مشهد</option>
                            <option value="shiraz">شیراز</option>
                            <option value="isfahan">اصفهان</option>
                            <option value="shomal">شمال (مازندران و گیلان)</option>
                        </select>
                    </div>
                    <div class="field-item">
                        <label>نوع ملک</label>
                        <select id="filter-type">
                            <option value="apartment">آپارتمان مسکونی</option>
                            <option value="villa">ویلا و باغ</option>
                            <option value="office">دفتر اداری و مطب</option>
                            <option value="land">زمین و کلنگی</option>
                        </select>
                    </div>
                    <div class="field-item">
                        <label>حداقل متراژ</label>
                        <select id="filter-area">
                            <option value="0">بدون محدودیت</option>
                            <option value="60">حداقل ۶۰ متر</option>
                            <option value="100">حداقل ۱۰۰ متر</option>
                            <option value="150">حداقل ۱۵۰ متر</option>
                        </select>
                    </div>
                    <div class="field-item">
                        <label>&nbsp;</label>
                        <button type="button" id="btn-search-listings" class="btn-do-search">
                            <span>🔍 جستجوی هوشمند</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- لیست آگهی‌های منتخب -->
    <section id="listings" class="amin-listings-section">
        <div class="amin-section-header">
            <div>
                <h2>فایل‌های ویژه و آگهی‌های امروز</h2>
                <p>املاک مسکونی و تجاری کارشناسی شده با قیمت مناسب</p>
            </div>
            <div class="view-switch">
                <span class="active">🏢 همه آگهی‌ها (<strong id="total-count">۴</strong>)</span>
            </div>
        </div>

        <div class="amin-listings-grid" id="listings-container">
            <!-- آگهی ۱ -->
            <article class="listing-card" data-city="tehran" data-type="apartment">
                <div class="card-thumb">
                    <span class="tag-urgent">فوری</span>
                    <div class="thumb-bg" style="background: linear-gradient(135deg, #1e293b, #334155);">🏙️</div>
                    <span class="location-tag">تهران، سعادت‌آباد</span>
                </div>
                <div class="card-content">
                    <h3>آپارتمان ۱۳۵ متری ۳ خوابه نوساز کلیدنخورده</h3>
                    <div class="listing-specs">
                        <span>📐 ۱۳۵ متر</span>
                        <span>🛏️ ۳ خواب</span>
                        <span>🚗 پارکینگ</span>
                        <span>🛗 آسانسور</span>
                    </div>
                    <div class="card-footer">
                        <div class="price-box">
                            <small>قیمت کل:</small>
                            <strong>۱۱,۵۰۰,۰۰۰,۰۰۰ تومان</strong>
                        </div>
                        <button type="button" class="btn-contact" onclick="alert('📞 تماس با مالک: 09121234567 (مهندس رادمان)')">📞 اطلاعات تماس</button>
                    </div>
                </div>
            </article>

            <!-- آگهی ۲ -->
            <article class="listing-card" data-city="shomal" data-type="villa">
                <div class="card-thumb">
                    <span class="tag-urgent" style="background:#10b981;">سند تک‌برگ</span>
                    <div class="thumb-bg" style="background: linear-gradient(135deg, #064e3b, #047857);">🏡</div>
                    <span class="location-tag">مازندران، متل‌قو</span>
                </div>
                <div class="card-content">
                    <h3>ویلای مدرن استخردار ۴۰۰ متری تریپلکس</h3>
                    <div class="listing-specs">
                        <span>📐 ۴۰۰ متر زمین</span>
                        <span>🛏️ ۴ خواب مستر</span>
                        <span>🏊 استخر چهارفصل</span>
                    </div>
                    <div class="card-footer">
                        <div class="price-box">
                            <small>قیمت کل:</small>
                            <strong>۱۸,۰۰۰,۰۰۰,۰۰۰ تومان</strong>
                        </div>
                        <button type="button" class="btn-contact" onclick="alert('📞 تماس با مشاور: 09112223344 (املاک دریا)')">📞 اطلاعات تماس</button>
                    </div>
                </div>
            </article>

            <!-- آگهی ۳ -->
            <article class="listing-card" data-city="tehran" data-type="apartment">
                <div class="card-thumb">
                    <div class="thumb-bg" style="background: linear-gradient(135deg, #431407, #9a3412);">🏢</div>
                    <span class="location-tag">تهران، ونک</span>
                </div>
                <div class="card-content">
                    <h3>رهن کامل آپارتمان ۹۰ متری بازسازی کامل</h3>
                    <div class="listing-specs">
                        <span>📐 ۹۰ متر</span>
                        <span>🛏️ ۲ خواب</span>
                        <span>🚗 پارکینگ</span>
                    </div>
                    <div class="card-footer">
                        <div class="price-box">
                            <small>رهن کامل:</small>
                            <strong>۱,۶۰۰,۰۰۰,۰۰۰ تومان</strong>
                        </div>
                        <button type="button" class="btn-contact" onclick="alert('📞 تماس با مالک: 09129876543')">📞 اطلاعات تماس</button>
                    </div>
                </div>
            </article>

            <!-- آگهی ۴ -->
            <article class="listing-card" data-city="shiraz" data-type="office">
                <div class="card-thumb">
                    <div class="thumb-bg" style="background: linear-gradient(135deg, #172554, #1d4ed8);">🏢</div>
                    <span class="location-tag">شیراز، قصرالدشت</span>
                </div>
                <div class="card-content">
                    <h3>واحد اداری و مطب ۷۵ متری تابلوخور عالی</h3>
                    <div class="listing-specs">
                        <span>📐 ۷۵ متر</span>
                        <span>🛗 ۲ لاین آسانسور</span>
                        <span>📍 بر اصلی</span>
                    </div>
                    <div class="card-footer">
                        <div class="price-box">
                            <small>قیمت کل:</small>
                            <strong>۵,۲۰۰,۰۰۰,۰۰۰ تومان</strong>
                        </div>
                        <button type="button" class="btn-contact" onclick="alert('📞 تماس با دفتر: 071-36280000')">📞 اطلاعات تماس</button>
                    </div>
                </div>
            </article>
        </div>
    </section>

    <!-- مدال ثبت رایگان آگهی -->
    <div id="listing-modal" class="amin-modal-overlay" style="display:none;">
        <div class="amin-modal-card">
            <button type="button" class="modal-close-btn" id="close-modal">&times;</button>
            <h3>➕ ثبت رایگان آگهی ملک</h3>
            <p>اطلاعات ملک خود را وارد کنید تا به صورت فوری در سایت منتشر شود.</p>

            <form id="new-listing-form" onsubmit="return false;">
                <div class="m-field">
                    <label>عنوان آگهی</label>
                    <input type="text" id="m-title" placeholder="مثلاً: آپارتمان ۱۰۰ متری در فرمانیه" required>
                </div>
                <div class="m-field-row">
                    <div class="m-field">
                        <label>شهر و منطقه</label>
                        <input type="text" id="m-loc" placeholder="تهران، فرمانیه" required>
                    </div>
                    <div class="m-field">
                        <label>متراژ (متر)</label>
                        <input type="number" id="m-area" placeholder="100" required>
                    </div>
                </div>
                <div class="m-field-row">
                    <div class="m-field">
                        <label>قیمت کل (تومان)</label>
                        <input type="text" id="m-price" placeholder="۷,۵۰۰,۰۰۰,۰۰۰" required>
                    </div>
                    <div class="m-field">
                        <label>شماره تماس شما</label>
                        <input type="tel" id="m-tel" placeholder="09xxxxxxxxx" dir="ltr" required>
                    </div>
                </div>
                <button type="button" id="btn-submit-listing" class="btn-do-search" style="width:100%; margin-top:16px;">
                    🚀 انتشار فوری آگهی در سامانه
                </button>
            </form>
        </div>
    </div>
</main>

<?php get_footer(); ?>
