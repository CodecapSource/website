<div class="page">
    <div class="page-title">
        <div class="page-title-left">
            <h1><span>Contact Us</span></h1>
            <p>Got any query? We would love to help you here!</p>
        </div>
        <div class="page-title-right">
            <div class="page-title-right-comp">
                <h3>+92-302-0000000</h3>
                <p>Our official 24/7<br>helpline</p>
            </div>
        </div>
    </div>
    <div class="page-content">

        <div class="contact">
            <div class="contact-l">
                <div class="contact-l-top">
                    <h3><span>we are on</span> Social Media</h3>
                    <div class="contact-l-social">
                        <a href=""><i class="fab fa-facebook"></i></a>
                        <a href=""><i class="fab fa-whatsapp"></i></a>
                        <a href=""><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="contact-l-main">
                    <p>We respond in 24 hours.</p>
                    <p>Checkout! There's knowledge base where we have answered some common questions, you might get help there.</p>
                </div>
            </div>
            <form method="POST" action="" class="contact-r">

                <?php if (isset($s_success) && !empty($s_success)): ?>
                    <div class="message success"><?=$s_success?></div>
                <?php endif; ?>
                <?php if (isset($s_error) && !empty($s_error)): ?>
                    <div class="message error"><?=$s_error?></div>
                <?php endif; ?>
                
                <?php if (isset($response)): ?>
                    <div class="message error">
                    <?php foreach ($response['data'] as $r): ?>
                        <b><?=ucfirst($r['field'])?></b> <?=$r['data'].'. '?>
                    <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
                <div class="input input-text">
                    <label for="fullname">Full Name</label>
                    <input type="text" id="fullname" name="name" placeholder="full name" value="">
                </div>
                <div class="input input-text">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="email address" value="">
                </div>
                <div class="input input-text">
                    <label for="message">Message</label>
                    <textarea type="text" id="message" name="message" placeholder="your message"></textarea>
                </div>
                <div class="input-submit">
                    <button type="submit"><i class="fas fa-arrow-right" aria-hidden="true"></i> Send</button>
                </div>
            </form>
        </div>

    </div>
</div>
