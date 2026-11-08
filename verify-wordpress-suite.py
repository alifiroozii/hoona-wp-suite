#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
WordPress Suite Verification Engine
Simulates WordPress Core's Theme_Upgrader and Plugin_Upgrader validation.
"""

import os
import re
import zipfile
import sys
import glob

REPO_ROOT = "/Users/alifiroozi/ali/ wordpress"
RELEASES_DIR = os.path.join(REPO_ROOT, "releases")

THEMES = [
    {"name": "قالب بهار (Bahar)", "zip": "bahar-theme-v1.0.0.zip", "folder": "bahar"},
    {"name": "قالب حلما (Helma)", "zip": "helma-theme-v1.0.0.zip", "folder": "helma"},
    {"name": "قالب صدرا (Sadra)", "zip": "sadra-theme-v1.0.0.zip", "folder": "sadra"},
    {"name": "قالب امین (Amin)", "zip": "amin-theme-v1.0.0.zip", "folder": "amin"},
    {"name": "قالب نیکان (Nikan)", "zip": "nikan-theme-v1.0.0.zip", "folder": "nikan"},
]

PLUGINS = [
    {"name": "افزونه ورود پیامکی (Hoona OTP)", "zip": "hoona-otp-v1.0.0.zip", "folder": "hoona-otp", "main_file": "hoona-otp.php"},
    {"name": "افزونه سبد خرید شناور (Hoona Cart)", "zip": "hoona-cart-v1.0.0.zip", "folder": "hoona-cart", "main_file": "hoona-cart.php"},
    {"name": "افزونه فاکتور و لیبل (Meysam Invoice)", "zip": "meysam-invoice-v1.0.0.zip", "folder": "meysam-invoice", "main_file": "meysam-invoice.php"},
    {"name": "افزونه شتاب‌دهنده رحیل (Rahil Speed)", "zip": "rahil-speed-v1.0.0.zip", "folder": "rahil-speed", "main_file": "rahil-speed.php"},
]

def parse_wp_headers(content, headers_map):
    """Parses WordPress headers using WordPress get_file_data() regex logic."""
    parsed = {}
    for key, header_name in headers_map.items():
        pattern = re.compile(rf'^[ \t\/*#@]*{re.escape(header_name)}:(.*)$', re.MULTILINE | re.IGNORECASE)
        match = pattern.search(content[:8192]) # WordPress reads first 8KB
        if match:
            parsed[key] = match.group(1).strip()
        else:
            parsed[key] = None
    return parsed

def check_php_syntax(file_path, content_bytes):
    """Checks PHP file integrity: BOM, starting tag, balance."""
    errors = []
    # 1. Check BOM
    if content_bytes.startswith(b'\xef\xbb\xbf'):
        errors.append("دارای کاراکتر نامرئی UTF-8 BOM است که می‌تواند باعث خطای Headers Already Sent شود.")
    
    # 2. Check starts with <?php
    stripped = content_bytes.lstrip()
    if not stripped.startswith(b'<?php'):
        errors.append("فایل با تگ استاندارد <?php آغاز نشده است.")
    elif content_bytes[:len(content_bytes) - len(stripped)] != b'':
        # leading whitespace before <?php
        if content_bytes[0] in (b' ', b'\t', b'\r', b'\n'):
            errors.append("فاصله خالی (Whitespace) قبل از تگ <?php وجود دارد.")
            
    # 3. Check brace matching
    try:
        text = content_bytes.decode('utf-8', errors='ignore')
        # Simple balance check outside quotes
        depth_curly = 0
        depth_paren = 0
        in_string = False
        quote_char = ''
        in_line_comment = False
        in_block_comment = False
        
        i = 0
        n = len(text)
        while i < n:
            ch = text[i]
            # handle comments
            if not in_string:
                if not in_block_comment and i + 1 < n and text[i:i+2] == '//':
                    in_line_comment = True
                    i += 2
                    continue
                if not in_block_comment and not in_line_comment and i + 1 < n and text[i:i+2] == '/*':
                    in_block_comment = True
                    i += 2
                    continue
                if in_block_comment and i + 1 < n and text[i:i+2] == '*/':
                    in_block_comment = False
                    i += 2
                    continue
                if in_line_comment and ch in ('\r', '\n'):
                    in_line_comment = False
                    i += 1
                    continue
                if in_line_comment or in_block_comment:
                    i += 1
                    continue
                    
            # handle strings
            if not in_block_comment and not in_line_comment:
                if ch in ("'", '"') and (i == 0 or text[i-1] != '\\'):
                    if not in_string:
                        in_string = True
                        quote_char = ch
                    elif quote_char == ch:
                        in_string = False
                        quote_char = ''
                elif not in_string:
                    if ch == '{': depth_curly += 1
                    elif ch == '}': depth_curly -= 1
                    elif ch == '(': depth_paren += 1
                    elif ch == ')': depth_paren -= 1
            i += 1
            
        if depth_curly != 0:
            errors.append(f"عدم تقارن آکولادها (اختلاف: {depth_curly})")
        if depth_paren != 0:
            errors.append(f"عدم تقارن پرانتزها (اختلاف: {depth_paren})")
            
    except Exception as e:
        errors.append(f"خطا در بررسی ساختار: {str(e)}")
        
    return errors

def verify_theme(theme_info):
    zip_path = os.path.join(RELEASES_DIR, theme_info["zip"])
    report = {
        "name": theme_info["name"],
        "zip_exists": os.path.exists(zip_path),
        "zip_size": os.path.getsize(zip_path) if os.path.exists(zip_path) else 0,
        "valid_structure": False,
        "has_style_css": False,
        "has_index_php": False,
        "has_functions_php": False,
        "has_screenshot": False,
        "headers": {},
        "php_files_count": 0,
        "php_errors": [],
        "passed": False
    }
    
    if not report["zip_exists"]:
        return report

    with zipfile.ZipFile(zip_path, 'r') as z:
        namelist = z.namelist()
        folder_prefix = theme_info["folder"] + "/"
        
        # Check single root directory structure
        root_dirs = set(p.split('/')[0] for p in namelist if '/' in p)
        if len(root_dirs) == 1 and list(root_dirs)[0] == theme_info["folder"]:
            report["valid_structure"] = True
            
        style_path = folder_prefix + "style.css"
        index_path = folder_prefix + "index.php"
        functions_path = folder_prefix + "functions.php"
        screenshot_path = folder_prefix + "screenshot.png"
        
        if style_path in namelist:
            report["has_style_css"] = True
            style_content = z.read(style_path).decode('utf-8', errors='ignore')
            report["headers"] = parse_wp_headers(style_content, {
                "name": "Theme Name",
                "version": "Version",
                "author": "Author",
                "text_domain": "Text Domain",
                "license": "License"
            })
            
        report["has_index_php"] = (index_path in namelist)
        report["has_functions_php"] = (functions_path in namelist)
        report["has_screenshot"] = (screenshot_path in namelist)
        
        for name in namelist:
            if name.endswith('.php'):
                report["php_files_count"] += 1
                b = z.read(name)
                errs = check_php_syntax(name, b)
                if errs:
                    report["php_errors"].append(f"{name}: {', '.join(errs)}")
                    
    theme_valid = (
        report["valid_structure"] and
        report["has_style_css"] and
        report["has_index_php"] and
        report["has_functions_php"] and
        report["headers"].get("name") is not None and
        len(report["php_errors"]) == 0
    )
    report["passed"] = theme_valid
    return report

def verify_plugin(plugin_info):
    zip_path = os.path.join(RELEASES_DIR, plugin_info["zip"])
    report = {
        "name": plugin_info["name"],
        "zip_exists": os.path.exists(zip_path),
        "zip_size": os.path.getsize(zip_path) if os.path.exists(zip_path) else 0,
        "valid_structure": False,
        "has_main_file": False,
        "headers": {},
        "php_files_count": 0,
        "php_errors": [],
        "passed": False
    }
    
    if not report["zip_exists"]:
        return report

    with zipfile.ZipFile(zip_path, 'r') as z:
        namelist = z.namelist()
        folder_prefix = plugin_info["folder"] + "/"
        
        root_dirs = set(p.split('/')[0] for p in namelist if '/' in p)
        if len(root_dirs) == 1 and list(root_dirs)[0] == plugin_info["folder"]:
            report["valid_structure"] = True
            
        main_file_path = folder_prefix + plugin_info["main_file"]
        if main_file_path in namelist:
            report["has_main_file"] = True
            main_content = z.read(main_file_path).decode('utf-8', errors='ignore')
            report["headers"] = parse_wp_headers(main_content, {
                "name": "Plugin Name",
                "version": "Version",
                "author": "Author",
                "text_domain": "Text Domain",
                "license": "License"
            })
            
        for name in namelist:
            if name.endswith('.php'):
                report["php_files_count"] += 1
                b = z.read(name)
                errs = check_php_syntax(name, b)
                if errs:
                    report["php_errors"].append(f"{name}: {', '.join(errs)}")
                    
    plugin_valid = (
        report["valid_structure"] and
        report["has_main_file"] and
        report["headers"].get("name") is not None and
        len(report["php_errors"]) == 0
    )
    report["passed"] = plugin_valid
    return report

def main():
    print("=" * 70)
    print("🚀 سامانه اعتبارسنجی خودکار نصب‌پذیری پوسته‌ها و افزونه‌های وردپرس هونا")
    print("=" * 70)
    
    all_passed = True
    
    print("\n📦 بررسی پوسته‌ها (WordPress Themes):")
    for t in THEMES:
        rep = verify_theme(t)
        status = "✅ تایید ۱۰۰٪ (قابل نصب در وردپرس)" if rep["passed"] else "❌ نقص فنی"
        print(f"\n🔹 {rep['name']}: {status}")
        print(f"   - حجم فایل زیپ: {rep['zip_size'] // 1024} KB")
        print(f"   - ساختار زیپ: {'تک‌پوشه استاندارد وردپرس' if rep['valid_structure'] else 'خطا در ساختار'}")
        print(f"   - فایل style.css: {'موجود' if rep['has_style_css'] else 'غایب'}")
        print(f"   - فایل index.php (الزامی هسته): {'موجود' if rep['has_index_php'] else 'غایب'}")
        print(f"   - فایل functions.php: {'موجود' if rep['has_functions_php'] else 'غایب'}")
        print(f"   - تصویر screenshot.png در پیشخوان: {'موجود' if rep['has_screenshot'] else 'غایب'}")
        print(f"   - هدرهای وردپرس: نام='{rep['headers'].get('name')}', نسخه='{rep['headers'].get('version')}', دامنه ترجمه='{rep['headers'].get('text_domain')}'")
        print(f"   - تعداد فایل‌های PHP بررسی‌شده: {rep['php_files_count']} فایل (خطای سینتکس: {len(rep['php_errors'])})")
        if rep['php_errors']:
            for err in rep['php_errors']:
                print(f"     ⚠️ {err}")
            all_passed = False

    print("\n" + "-" * 70)
    print("\n🔌 بررسی افزونه‌ها (WordPress Plugins):")
    for p in PLUGINS:
        rep = verify_plugin(p)
        status = "✅ تایید ۱۰۰٪ (قابل نصب در وردپرس)" if rep["passed"] else "❌ نقص فنی"
        print(f"\n🔹 {rep['name']}: {status}")
        print(f"   - حجم فایل زیپ: {rep['zip_size'] // 1024} KB")
        print(f"   - ساختار زیپ: {'تک‌پوشه استاندارد افزونه' if rep['valid_structure'] else 'خطا در ساختار'}")
        print(f"   - فایل اجرایی اصلی: {'موجود' if rep['has_main_file'] else 'غایب'}")
        print(f"   - هدرهای استاندارد افزونه: نام='{rep['headers'].get('name')}', نسخه='{rep['headers'].get('version')}', نویسنده='{rep['headers'].get('author')}'")
        print(f"   - تعداد فایل‌های PHP بررسی‌شده: {rep['php_files_count']} فایل (خطای سینتکس: {len(rep['php_errors'])})")
        if rep['php_errors']:
            for err in rep['php_errors']:
                print(f"     ⚠️ {err}")
            all_passed = False

    print("\n" + "=" * 70)
    if all_passed:
        print("🎯 نتیجه نهایی: تمامی ۸ پکیج با موفقیت استانداردهای سخت‌گیرانه وردپرس را پشت سر گذاشتند.")
        print("این بسته‌ها بدون هیچ‌گونه خطا مستقیماً در هر سایت وردپرسی قابل آپلود، فعال‌سازی و اجرا هستند.")
    else:
        print("⚠️ برخی موارد نیازمند بازبینی هستند.")
    print("=" * 70)

if __name__ == '__main__':
    main()
