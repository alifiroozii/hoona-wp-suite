<?php
/**
 * The header for Nikan Medical Theme
 *
 * @package Nikan
 */

if (!defined('ABSPATH')) {
    exit;
}

$opts = get_option('nikan_theme_options', []);
$clinic_name     = $opts['clinic_name'] ?? 'کلینیک تخصصی و جراحی نیکان';
$clinic_phone    = $opts['clinic_phone'] ?? '021-88776655';
$emergency_phone = $opts['emergency_phone'] ?? '09120000000';
$working_hours   = $opts['working_hours'] ?? 'همه روزه از ۸ صبح الی ۲۱';
$address         = $opts['address'] ?? 'تهران، خیابان ولیعصر، ساختمان پزشکان نیکان';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <!-- Top Bar -->
    <div class="clinic-topbar">
        <div class="container topbar-flex">
            <div class="topbar-info">
                <span><i class="fas fa-map-marker-alt"></i> <?php echo esc_html($address); ?></span>
                <span class="divider">&bull;</span>
                <span><i class="fas fa-clock"></i> <?php echo esc_html($working_hours); ?></span>
            </div>
            <div class="topbar-contact">
                <span><i class="fas fa-phone-alt"></i> پذیرش: <a href="tel:<?php echo esc_attr(str_replace(['-', ' '], '', $clinic_phone)); ?>"><?php echo esc_html($clinic_phone); ?></a></span>
                <span class="emergency-badge"><i class="fas fa-ambulance"></i> اورژانس: <?php echo esc_html($emergency_phone); ?></span>
            </div>
        </div>
    </div>

    <!-- Main Navigation Header -->
    <header id="masthead" class="site-header">
        <div class="container header-flex">
            <div class="site-branding">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="custom-logo-link" rel="home">
                    <div class="logo-box">
                        <div class="logo-icon"><i class="fas fa-heartbeat"></i></div>
                        <div class="logo-text">
                            <span class="brand-title"><?php echo esc_html($clinic_name); ?></span>
                            <span class="brand-tagline">مرکز تخصصی پزشکی و جراحی زیبایی</span>
                        </div>
                    </div>
                </a>
            </div>

            <nav id="site-navigation" class="main-navigation">
                <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                    <i class="fas fa-bars"></i>
                </button>
                <ul class="nav-menu">
                    <li><a href="<?php echo esc_url(home_url('/')); ?>"><i class="fas fa-home"></i> صفحه اصلی</a></li>
                    <li><a href="#services"><i class="fas fa-stethoscope"></i> خدمات درمانی</a></li>
                    <li><a href="#doctors"><i class="fas fa-user-md"></i> پزشکان متخصص</a></li>
                    <li><a href="#before-after"><i class="fas fa-columns"></i> قبل و بعد جراحی</a></li>
                    <li><a href="#testimonials"><i class="fas fa-comment-medical"></i> تجربیات بیماران</a></li>
                    <li><a href="#contact"><i class="fas fa-map-marked-alt"></i> تماس با کلینیک</a></li>
                </ul>
            </nav>

            <div class="header-action">
                <a href="#booking-section" class="btn-book-header">
                    <i class="fas fa-calendar-check"></i> نوبت‌دهی آنلاین
                </a>
            </div>
        </div>
    </header>
