<?php
$theme_dir = get_template_directory_uri();
?>
<div class="contact-section">
    <div class="container">
        <div class="contact-content">
            <div class="form-container">
                <h2 class="head">هل تحتاج إلى مساعدة؟</h2>
                <p>املأ بياناتك و سوف يقوم خبير عقارى بالاتصال بك فى اقرب وقت</p>
                <form>
                    <input type="text" id="name" name="name" placeholder="الاسم" required>
                    <input type="tel" id="mobile" name="mobile" pattern="[0-9]*" placeholder="رقم الهاتف" required>
                    <input type=" email" id="email" name="email" placeholder="البريد الالكتروني" required>
                    <textarea id="message" name="message" rows="4" placeholder="رسالتك" required></textarea>
                    <button type="submit">أرسل</button>
                </form>
            </div>
            <div class="image-container">
                <img data-src="<?php echo $theme_dir ?>/assets/imgs/contact.jpg" alt="Office Image" class="offical-img lazyload">
                <img data-src="<?php echo $theme_dir ?>/assets/imgs/logo.png" alt="Office Image" class="logo-contact lazyload">
            </div>
        </div>
    </div>
</div>

