<?php
/**
 * The front page template for Nikan Medical Theme
 *
 * @package Nikan
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$opts = get_option('nikan_theme_options', []);
$clinic_phone = $opts['clinic_phone'] ?? '021-88776655';
?>

<main id="primary" class="site-main">

    <!-- 1. HERO SECTION -->
    <section class="clinic-hero">
        <div class="container hero-grid">
            <div class="hero-content">
                <div class="hero-badge">
                    <i class="fas fa-certificate"></i> مرکز تخصصی و فوق‌تخصصی دارای مجوز رسمی
                </div>
                <h1 class="hero-title">
                    سلامت و زیبایی شما،<br>
                    <span>امانت دست برترین اساتید درمانی</span>
                </h1>
                <p class="hero-desc">
                    کلینیک نیکان محیطی آرام، مدرن و مجهز به آخرین فناوری‌های تشخیصی و درمانی جهان را فراهم آورده تا بدون اتلاف وقت و با آرامش خاطر، فرآیند درمان خود را سپری کنید.
                </p>

                <!-- Doctor Search Bar -->
                <div class="doctor-search-box">
                    <form class="search-form-flex" onsubmit="event.preventDefault(); document.getElementById('booking-section').scrollIntoView({behavior: 'smooth'});">
                        <div class="input-group">
                            <i class="fas fa-stethoscope"></i>
                            <select id="heroSpecialty">
                                <option value="">انتخاب تخصص پزشکی...</option>
                                <option value="dental">دندان‌پزشکی دیجیتال و ایمپلنت</option>
                                <option value="cardio">متخصص قلب و عروق</option>
                                <option value="skin">پوست، مو و لیزر درمانی</option>
                                <option value="cosmetic">جراحی پلاستیک و زیبایی</option>
                                <option value="ortho">ارتوپدی و آسیب‌های ورزشی</option>
                            </select>
                        </div>
                        <button type="submit" class="btn-search-hero">
                            <i class="fas fa-search"></i> جستجو و نوبت‌دهی
                        </button>
                    </form>
                </div>

                <!-- Trust Points -->
                <div class="hero-stats">
                    <div class="stat-item">
                        <span class="stat-num">+۴۵,۰۰۰</span>
                        <span class="stat-label">ویزیت و درمان موفق</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-num">۳۸</span>
                        <span class="stat-label">پزشک فوق‌تخصص و جراح</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-num">۹۹.۴٪</span>
                        <span class="stat-label">رضایت بیماران و مراجعین</span>
                    </div>
                </div>
            </div>

            <!-- Hero Visual -->
            <div class="hero-visual">
                <div class="visual-card-main">
                    <div class="visual-header">
                        <div class="pulse-indicator"></div>
                        <span>پذیرش فعال کلینیک نیکان</span>
                    </div>
                    <div class="card-doctor-preview">
                        <div class="doc-avatar"><i class="fas fa-user-md fa-3x"></i></div>
                        <div>
                            <h4>دکتر علیرضا صدقی</h4>
                            <p>فوق‌تخصص جراحی قلب و عروق &bull; کد نظام: ۱۲۴۵۹</p>
                        </div>
                    </div>
                    <div class="quick-tags">
                        <span><i class="fas fa-check-circle"></i> طرف قرارداد با کلیه بیمه‌ها</span>
                        <span><i class="fas fa-check-circle"></i> پرونده الکترونیک سلامت</span>
                        <span><i class="fas fa-check-circle"></i> استریلیزاسیون بیمارستانی</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. APPOINTMENT BOOKING SECTION -->
    <section id="booking-section" class="section booking-section">
        <div class="container">
            <div class="section-title-wrap text-center">
                <span class="section-badge"><i class="fas fa-calendar-alt"></i> رزرو آنلاین نوبت</span>
                <h2 class="section-title">نوبت‌دهی هوشمند بدون معطلی در مطب</h2>
                <p class="section-subtitle">پزشک و زمان مناسب خود را انتخاب کنید؛ پیامک تایید با کد رهگیری بلافاصله ارسال خواهد شد.</p>
            </div>

            <div class="booking-wizard-card">
                <form id="nikanBookingForm">
                    <div class="wizard-grid">
                        <!-- Step 1: Select Specialty & Doctor -->
                        <div class="wizard-col">
                            <label class="wizard-label"><i class="fas fa-user-md"></i> ۱. انتخاب تخصص و پزشک</label>
                            <select id="bookDoctor" class="wizard-input" required>
                                <option value="">لطفاً پزشک معالج را انتخاب کنید</option>
                                <option value="دکتر علیرضا صدقی (فوق‌تخصص قلب و عروق)">دکتر علیرضا صدقی (فوق‌تخصص قلب و عروق)</option>
                                <option value="دکتر مریم شایان‌فر (متخصص دندان‌پزشکی و ایمپلنت)">دکتر مریم شایان‌فر (متخصص دندان‌پزشکی و ایمپلنت)</option>
                                <option value="دکتر کیانوش رحیمی (جراح پلاستیک و زیبایی)">دکتر کیانوش رحیمی (جراح پلاستیک و زیبایی)</option>
                                <option value="دکتر سارا افشار (متخصص پوست، مو و لیزر)">دکتر سارا افشار (متخصص پوست، مو و لیزر)</option>
                            </select>

                            <label class="wizard-label" style="margin-top: 15px;"><i class="fas fa-calendar-day"></i> ۲. تاریخ حضور (تقویم شمسی)</label>
                            <select id="bookDate" class="wizard-input" required>
                                <option value="">انتخاب روز ویزیت...</option>
                                <option value="شنبه ۲۰ آبان ۱۴۰۵">شنبه ۲۰ آبان ۱۴۰۵ (عصر)</option>
                                <option value="یک‌شنبه ۲۱ آبان ۱۴۰۵">یک‌شنبه ۲۱ آبان ۱۴۰۵ (عصر)</option>
                                <option value="دوشنبه ۲۲ آبان ۱۴۰۵">دوشنبه ۲۲ آبان ۱۴۰۵ (صبح و عصر)</option>
                                <option value="سه‌شنبه ۲۳ آبان ۱۴۰۵">سه‌شنبه ۲۳ آبان ۱۴۰۵ (عصر)</option>
                                <option value="چهارشنبه ۲۴ آبان ۱۴۰۵">چهارشنبه ۲۴ آبان ۱۴۰۵ (عصر)</option>
                            </select>
                        </div>

                        <!-- Step 2: Time Slots -->
                        <div class="wizard-col">
                            <label class="wizard-label"><i class="fas fa-clock"></i> ۳. انتخاب ساعت ویزیت</label>
                            <div class="time-slots-grid">
                                <label class="slot-pill"><input type="radio" name="time_slot" value="16:00" checked><span>۱۶:۰۰</span></label>
                                <label class="slot-pill"><input type="radio" name="time_slot" value="16:30"><span>۱۶:۳۰</span></label>
                                <label class="slot-pill"><input type="radio" name="time_slot" value="17:00"><span>۱۷:۰۰</span></label>
                                <label class="slot-pill"><input type="radio" name="time_slot" value="17:30"><span>۱۷:۳۰</span></label>
                                <label class="slot-pill"><input type="radio" name="time_slot" value="18:00"><span>۱۸:۰۰</span></label>
                                <label class="slot-pill"><input type="radio" name="time_slot" value="18:30"><span>۱۸:۳۰</span></label>
                                <label class="slot-pill"><input type="radio" name="time_slot" value="19:00"><span>۱۹:۰۰</span></label>
                                <label class="slot-pill"><input type="radio" name="time_slot" value="19:30"><span>۱۹:۳۰</span></label>
                            </div>

                            <label class="wizard-label" style="margin-top: 15px;"><i class="fas fa-comment-medical"></i> علائم اولیه یا شرح حال بیمار</label>
                            <input type="text" id="bookNotes" class="wizard-input" placeholder="علت مراجعه (اختیاری)">
                        </div>

                        <!-- Step 3: Patient Info -->
                        <div class="wizard-col">
                            <label class="wizard-label"><i class="fas fa-user"></i> ۴. مشخصات بیمار</label>
                            <input type="text" id="patientName" class="wizard-input" placeholder="نام و نام خانوادگی بیمار" required>
                            
                            <label class="wizard-label" style="margin-top: 15px;"><i class="fas fa-mobile-alt"></i> شماره همراه (جهت ارسال کد پیگیری)</label>
                            <input type="tel" id="patientPhone" class="wizard-input" placeholder="09123456789" style="direction: ltr;" required>

                            <button type="button" class="btn-submit-booking" onclick="submitNikanBooking()">
                                <i class="fas fa-check-circle"></i> ثبت قطعی و دریافت کد نوبت
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Booking Success Modal -->
                <div id="bookingResultBox" class="booking-result" style="display: none;">
                    <div class="result-card">
                        <div class="result-icon"><i class="fas fa-check-double"></i></div>
                        <h3>نوبت شما با موفقیت ثبت گردید</h3>
                        <p>کد پیگیری اختصاصی شما: <strong id="resTrackingCode" style="color: #0d9488; font-size: 20px;">NK-884920</strong></p>
                        <div class="result-details">
                            <span id="resDoctor">پزشک معالج: -</span> &bull; 
                            <span id="resDate">تاریخ: -</span>
                        </div>
                        <p style="font-size: 13px; color: #64748b; margin-top: 10px;">
                            پیامک مشخصات نوبت و آدرس درمانگاه به شماره شما ارسال شد. لطفاً ۱۵ دقیقه قبل از زمان مقرر در کلینیک حضور داشته باشید.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. SERVICES SECTION -->
    <section id="services" class="section services-section">
        <div class="container">
            <div class="section-title-wrap text-center">
                <span class="section-badge"><i class="fas fa-hospital-user"></i> خدمات کلینیک</span>
                <h2 class="section-title">دپارتمان‌های فوق‌تخصصی نیکان</h2>
            </div>

            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon"><i class="fas fa-heartbeat"></i></div>
                    <h3>قلب و عروق</h3>
                    <p>نوار قلب، اکوکاردیوگرافی، تست ورزش و هولتر فشار خون با پیشرفته‌ترین مانیتورینگ‌های اروپایی.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon"><i class="fas fa-tooth"></i></div>
                    <h3>دندان‌پزشکی دیجیتال</h3>
                    <p>ایمپلنت‌های بدون جراحی، لمینت سرامیکی و کامپوزیت با اسکن ۳ بعدی دهان.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon"><i class="fas fa-spa"></i></div>
                    <h3>پوست، مو و زیبایی</h3>
                    <p>تزریق ژل و بوتاکس، هایفوتراپی جوانسازی و لیزر موهای زائد با دستگاه‌های بدون درد الکساندرایت.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon"><i class="fas fa-bone"></i></div>
                    <h3>ارتوپدی و مفاصل</h3>
                    <p>درمان دردهای مفصلی، فیزیوتراپی پیشرفته، درمان دیسک و درمان آسیب‌های شایع ورزشی.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon"><i class="fas fa-eye"></i></div>
                    <h3>چشم‌پزشکی و بینایی</h3>
                    <p>تعیین نمره عینک با کامپیوتر، لیزیک و پی‌آرکی و معاینه فشار چشم با دستگاه‌های غیرتماسی.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon"><i class="fas fa-vial"></i></div>
                    <h3>چکاپ و آزمایشگاه</h3>
                    <p>انجام تمامی آزمایش‌های خون و بیوشیمی با تحویل آنلاین جواب در کمتر از ۲۴ ساعت.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. BEFORE / AFTER INTERACTIVE SLIDER -->
    <section id="before-after" class="section before-after-section">
        <div class="container">
            <div class="section-title-wrap text-center">
                <span class="section-badge"><i class="fas fa-columns"></i> گالری نتایج درمان</span>
                <h2 class="section-title">اسلایدر مقایسه قبل و بعد جراحی</h2>
                <p class="section-subtitle">خط وسط را با ماوس یا لمس به چپ و راست بکشید تا تفاوت معجزه‌آسای نتیجه درمان را مشاهده نمایید.</p>
            </div>

            <div class="ba-container">
                <div class="ba-slider-box" id="baSlider">
                    <!-- Before Layer (Background) -->
                    <div class="ba-image ba-before">
                        <div class="ba-badge before-badge">قبل از درمان (Before)</div>
                        <div class="ba-placeholder-img before-img">
                            <i class="fas fa-frown fa-4x" style="color: #cbd5e1; margin-bottom: 15px;"></i>
                            <h3>ایمپلنت و جراحی فک</h3>
                            <p>به‌هم‌ریختگی دندانی و آسیب استخوان فک قبل از عمل</p>
                        </div>
                    </div>

                    <!-- After Layer (Foreground clipped) -->
                    <div class="ba-image ba-after" id="baAfterLayer">
                        <div class="ba-badge after-badge">بعد از درمان (After)</div>
                        <div class="ba-placeholder-img after-img">
                            <i class="fas fa-smile-beam fa-4x" style="color: #0d9488; margin-bottom: 15px;"></i>
                            <h3>نتیجه نهایی درمان دیجیتال</h3>
                            <p>طراحی لبخند هالیوودی و اصلاح کامل تقارن چهره</p>
                        </div>
                    </div>

                    <!-- Handle -->
                    <div class="ba-handle" id="baHandle">
                        <div class="handle-line"></div>
                        <div class="handle-circle"><i class="fas fa-arrows-alt-h"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. DOCTORS TEAM -->
    <section id="doctors" class="section doctors-section">
        <div class="container">
            <div class="section-title-wrap text-center">
                <span class="section-badge"><i class="fas fa-user-md"></i> کادر تخصصی</span>
                <h2 class="section-title">پزشکان و جراحان کلینیک نیکان</h2>
            </div>

            <div class="doctors-grid">
                <div class="doctor-card">
                    <div class="doc-img-box"><i class="fas fa-user-md fa-4x"></i></div>
                    <h3>دکتر علیرضا صدقی</h3>
                    <span class="doc-specialty">فوق‌تخصص جراحی قلب و عروق</span>
                    <p class="doc-bio">استاد تمام دانشگاه علوم پزشکی، دارای ۱۵ سال سابقه جراحی‌های پیچیده عروقی و پیوند.</p>
                    <div class="doc-meta">
                        <span><i class="fas fa-id-badge"></i> نظام: ۱۲۴۵۹</span>
                        <span><i class="fas fa-clock"></i> شنبه، دوشنبه</span>
                    </div>
                    <a href="#booking-section" class="btn-doc-book">رزرو ویزیت</a>
                </div>

                <div class="doctor-card">
                    <div class="doc-img-box"><i class="fas fa-user-nurse fa-4x"></i></div>
                    <h3>دکتر مریم شایان‌فر</h3>
                    <span class="doc-specialty">متخصص دندان‌پزشکی دیجیتال و ایمپلنت</span>
                    <p class="doc-bio">فارغ‌التحصیل از آلمان، عضو انجمن ایمپلنتولوژی اروپا با بیش از ۸,۰۰۰ کاشت موفق.</p>
                    <div class="doc-meta">
                        <span><i class="fas fa-id-badge"></i> نظام: ۳۴۸۸۲</span>
                        <span><i class="fas fa-clock"></i> یک‌شنبه، چهارشنبه</span>
                    </div>
                    <a href="#booking-section" class="btn-doc-book">رزرو ویزیت</a>
                </div>

                <div class="doctor-card">
                    <div class="doc-img-box"><i class="fas fa-user-md fa-4x"></i></div>
                    <h3>دکتر کیانوش رحیمی</h3>
                    <span class="doc-specialty">فوق‌تخصص جراحی پلاستیک و زیبایی</span>
                    <p class="doc-bio">بورد تخصصی جراحی بینی، پروتز و پیکرتراشی با متدهای روز دنیا بدون بیهوشی سنگین.</p>
                    <div class="doc-meta">
                        <span><i class="fas fa-id-badge"></i> نظام: ۲۹۸۷۱</span>
                        <span><i class="fas fa-clock"></i> همه‌روزه عصرها</span>
                    </div>
                    <a href="#booking-section" class="btn-doc-book">رزرو ویزیت</a>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. EMERGENCY CONTACT CTA -->
    <section id="contact" class="emergency-cta">
        <div class="container emergency-flex">
            <div>
                <h2>نیاز به مشاوره اورژانسی یا تعیین وقت فوری دارید؟</h2>
                <p>پزشکان کشیک و کادر پذیرش کلینیک در تمامی ساعات شبانه‌روز آماده پاسخگویی به شما هستند.</p>
            </div>
            <div class="cta-actions">
                <a href="tel:<?php echo esc_attr(str_replace(['-', ' '], '', $clinic_phone)); ?>" class="btn-call-emergency">
                    <i class="fas fa-phone-alt"></i> تماس فوری: <?php echo esc_html($clinic_phone); ?>
                </a>
            </div>
        </div>
    </section>

</main>

<?php
get_footer();
