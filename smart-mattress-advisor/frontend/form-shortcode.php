<?php
if ( ! defined( 'ABSPATH' ) ) exit;

add_shortcode('mattress_advisor_form', 'mattress_advisor_form_shortcode');

function mattress_advisor_form_shortcode() {
    $style_options = get_option('mattress_advisor_style_options', []);
    $primary_color = !empty($style_options['primary_color']) ? sanitize_hex_color($style_options['primary_color']) : '#4CAF50';
    $accent_color  = !empty($style_options['accent_color']) ? sanitize_hex_color($style_options['accent_color']) : '#1f2937';
    $bg_color      = !empty($style_options['bg_color']) ? sanitize_hex_color($style_options['bg_color']) : '#ffffff';

    ob_start();
    ?>
    <style>
        #mattress-advisor-container{--advisor-primary:<?php echo esc_attr($primary_color ?: '#4CAF50'); ?>;--advisor-accent:<?php echo esc_attr($accent_color ?: '#1f2937'); ?>;--advisor-bg:<?php echo esc_attr($bg_color ?: '#ffffff'); ?>;background:var(--advisor-bg)}
        #mattress-advisor-container .progress-fill,
        #mattress-advisor-container .mattress-submit-btn,
        #mattress-advisor-container .mattress-next-btn{background:var(--advisor-primary)!important;border-color:var(--advisor-primary)!important}
        #mattress-advisor-container .step.active .step-number,
        #mattress-advisor-container .option.selected{border-color:var(--advisor-primary)!important}
        #mattress-advisor-container .step-header h2{color:var(--advisor-accent)!important}
    </style>

    <div id="mattress-advisor-container" class="mattress-wizard">
        <div class="wizard-progress">
            <div class="progress-bar"><div class="progress-fill" id="progress-fill"></div></div>
            <div class="progress-steps">
                <div class="step active" data-step="1"><span class="step-number">1</span></div>
                <div class="step" data-step="2"><span class="step-number">2</span></div>
                <div class="step" data-step="3"><span class="step-number">3</span></div>
                <div class="step" data-step="4"><span class="step-number">4</span></div>
            </div>
        </div>

        <form id="mattress-advisor-form" class="mattress-form">
            <div class="form-step active" id="step-1">
                <div class="step-header">
                    <h2>اطلاعات تماس</h2>
                    <p>برای دریافت پیشنهاد درب لطفاً اطلاعات خود را وارد کنید.</p>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="full_name">نام و نام خانوادگی <span class="required">*</span></label>
                        <input type="text" id="full_name" name="full_name" required>
                    </div>
                    <div class="form-group">
                        <label for="mobile">شماره موبایل <span class="required">*</span></label>
                        <input type="tel" id="mobile" name="mobile" required pattern="09[0-9]{9}" placeholder="09123456789">
                    </div>
                </div>
            </div>

            <div class="form-step" id="step-2">
                <div class="step-header">
                    <h2>نوع درب</h2>
                    <p>مشخص کنید درب ورودی می‌خواهید یا داخلی.</p>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label>نوع درب <span class="required">*</span></label>
                        <div class="form-options" role="radiogroup" aria-label="نوع درب">
                            <label class="option"><input type="radio" name="door_type" value="entrance" required> <span class="option-label">درب ورودی</span></label>
                            <label class="option"><input type="radio" name="door_type" value="interior" required> <span class="option-label">درب داخلی</span></label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-step" id="step-3">
                <div class="step-header">
                    <h2>جزئیات درب ورودی</h2>
                    <p>این بخش فقط برای درب ورودی است.</p>
                </div>
                <div class="form-grid door-section" data-door="entrance" style="display:none;">
                    <div class="form-group">
                        <label>نوع ساختمان <span class="required">*</span></label>
                        <div class="form-options" role="radiogroup">
                            <label class="option"><input type="radio" name="building_type" value="apartment" data-conditional-required="entrance"> <span class="option-label">آپارتمانی</span></label>
                            <label class="option"><input type="radio" name="building_type" value="villa" data-conditional-required="entrance"> <span class="option-label">ویلایی</span></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>برخورد آفتاب و باران <span class="required">*</span></label>
                        <div class="form-options" role="radiogroup">
                            <label class="option"><input type="radio" name="weather_exposure" value="yes" data-conditional-required="entrance"> <span class="option-label">بله</span></label>
                            <label class="option"><input type="radio" name="weather_exposure" value="no" data-conditional-required="entrance"> <span class="option-label">خیر</span></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="facade_style">سبک نما <span class="required">*</span></label>
                        <select id="facade_style" name="facade_style" data-conditional-required="entrance">
                            <option value="">انتخاب کنید</option>
                            <option value="modern">مدرن</option>
                            <option value="neo_classic">نئو کلاسیک</option>
                            <option value="classic">کلاسیک</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="entrance_material">متریال درب <span class="required">*</span></label>
                        <select id="entrance_material" name="entrance_material" data-conditional-required="entrance">
                            <option value="">انتخاب کنید</option>
                            <option value="wood">چوب</option>
                            <option value="metal">فلزی</option>
                            <option value="glass">شیشه</option>
                            <option value="thermowood">ترمووود</option>
                            <option value="mdf">MDF</option>
                            <option value="synthetic_coating">روکش مصنوعی</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="door_height">ارتفاع (cm) <span class="required">*</span></label>
                        <input type="number" id="door_height" name="door_height" min="150" max="350" data-conditional-required="entrance">
                    </div>
                    <div class="form-group">
                        <label for="door_width">عرض (cm) <span class="required">*</span></label>
                        <input type="number" id="door_width" name="door_width" min="60" max="350" data-conditional-required="entrance">
                        <small>تا ارتفاع 235 و عرض 220 مناسب درب ضد سرقت است؛ بزرگ‌تر از این ابعاد معمولاً پیووت پیشنهاد می‌شود.</small>
                    </div>
                </div>
                <div class="door-type-hint" data-hint="interior" style="display:none;">برای درب داخلی در مرحله بعدی اطلاعات را تکمیل کنید.</div>
            </div>

            <div class="form-step" id="step-4">
                <div class="step-header">
                    <h2>جزئیات درب داخلی</h2>
                    <p>این بخش فقط برای درب داخلی است.</p>
                </div>
                <div class="form-grid door-section" data-door="interior" style="display:none;">
                    <div class="form-group">
                        <label>ضدآب <span class="required">*</span></label>
                        <div class="form-options" role="radiogroup">
                            <label class="option"><input type="radio" name="waterproof" value="yes" data-conditional-required="interior"> <span class="option-label">بله</span></label>
                            <label class="option"><input type="radio" name="waterproof" value="no" data-conditional-required="interior"> <span class="option-label">خیر</span></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>چهارچوب فلزی نصب شده <span class="required">*</span></label>
                        <div class="form-options" role="radiogroup">
                            <label class="option"><input type="radio" name="metal_frame_installed" value="yes" data-conditional-required="interior"> <span class="option-label">بله</span></label>
                            <label class="option"><input type="radio" name="metal_frame_installed" value="no" data-conditional-required="interior"> <span class="option-label">خیر</span></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="usage_space">فضای مورد استفاده <span class="required">*</span></label>
                        <select id="usage_space" name="usage_space" data-conditional-required="interior">
                            <option value="">انتخاب کنید</option>
                            <option value="room">اتاق</option>
                            <option value="wc">سرویس بهداشتی</option>
                            <option value="bathroom">حمام</option>
                            <option value="pool">استخر</option>
                            <option value="management">اتاق مدیریت</option>
                            <option value="conference">کنفرانس</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="interior_style">سبک <span class="required">*</span></label>
                        <select id="interior_style" name="interior_style" data-conditional-required="interior">
                            <option value="">انتخاب کنید</option>
                            <option value="modern">مدرن</option>
                            <option value="neo_classic">نئو کلاسیک</option>
                            <option value="classic">کلاسیک</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="color_theme">تم رنگ <span class="required">*</span></label>
                        <select id="color_theme" name="color_theme" data-conditional-required="interior">
                            <option value="">انتخاب کنید</option>
                            <option value="colored">رنگی</option>
                            <option value="black_theme">تم سیاه</option>
                            <option value="light_theme">تم روشن</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>نوار درزگیر <span class="required">*</span></label>
                        <div class="form-options" role="radiogroup">
                            <label class="option"><input type="radio" name="weatherstrip" value="yes" data-conditional-required="interior"> <span class="option-label">دارد</span></label>
                            <label class="option"><input type="radio" name="weatherstrip" value="no" data-conditional-required="interior"> <span class="option-label">ندارد</span></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="interior_material">جنس درب <span class="required">*</span></label>
                        <select id="interior_material" name="interior_material" data-conditional-required="interior">
                            <option value="">انتخاب کنید</option>
                            <option value="mdf_melamine">MDF و ملامینه</option>
                            <option value="abs">ABS</option>
                            <option value="polywood">پلی‌وود</option>
                        </select>
                    </div>
                </div>
                <div class="door-type-hint" data-hint="entrance" style="display:none;">برای درب ورودی در مرحله قبل اطلاعات را تکمیل کرده‌اید.</div>
            </div>

            <div class="form-navigation">
                <button type="button" id="prev-btn" class="mattress-nav-btn mattress-prev-btn" style="display: none;">مرحله قبل</button>
                <button type="button" id="next-btn" class="mattress-nav-btn mattress-next-btn">مرحله بعد</button>
                <button type="submit" id="submit-btn" class="mattress-nav-btn mattress-submit-btn" style="display: none;">دریافت پیشنهاد درب</button>
            </div>
        </form>

        <div id="mattress-result" class="result-container" style="display: none;"></div>
    </div>
    <?php
    wp_enqueue_script('mattress-form-js', MATTRESS_ADVISOR_URL . 'frontend/form.js', ['jquery'], MATTRESS_ADVISOR_VERSION, true);
    wp_localize_script('mattress-form-js', 'mattress_form', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('mattress_nonce')
    ]);
    return ob_get_clean();
}
