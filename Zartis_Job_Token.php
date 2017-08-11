<style>
  .updated {
    display: none;
  }
</style>


<div class="zar_body">
  <div class="wrap">

    <div align="c16">
      <div class="branding">
        <img src="https://zartis.blob.core.windows.net/public/Hire-Hive-Logo.png" style="border:none;" />
      </div>
    </div>

    <div id="main" role="main" class="flex">
      <div class="c8" id="Register">
        <div class="content">
          <h2 class="h2">Almost there! </h2>
          <p class="p intro">To add jobs to your WordPress site you need a <strong>HireHive paid account</strong> or the <strong>14 Day Free Trial</strong> to demo this plugin. It takes less than 20 seconds. </p>
          <h3>What you get with HireHive</h3>
          <ul class="list">
            <li>Custom careers site</li>
            <li>Job posting and sharing</li>
            <li>Candidate management and pipeline</li>
            <li>Full email and message communication</li>
            <li>Access for your team</li>
          </ul>
          <h3>Put jobs on your site now</h3>
          <p class="p">When you sign up below, you will be given a token. Save this and you will then have access to plugin settings.</p>


          <?php if(!isset($_GET["WordPressURL"])) : ?>
            <div class="cent">
              <a href="https://my.hirehive.io/Register/WordPress" class="btn save buttons a">
                <span>Sign up and get token now</span>
              </a>
              <br>
              <br>
              <a href="https://my.hirehive.io/#/settings/wordpress">Already have an account? Get token here.</a>

            </div>
            <!-- END OF cent -->
            <?php endif; ?>

        </div>
        <!-- END OF content -->

        <div style="margin-top:35px">
          <h3>Enter HireHive WordPress Token</h3>
          <p>Already have an account? <a href="https://my.hirehive.io/#/Settings/Careerpage" target="_blank">Get token here.</a></p>
          <form method="post" action="options.php">
            <?php wp_nonce_field('update-options'); ?>
              <fieldset class="default fieldset">
                <ol class="ol">
                  <!-- Email Input  -->
                  <li>
                    <label class='label' for="email">
                      Your token
                    </label>
                    <input class="token-input" id="Zartis_Unique_ID" name="Zartis_Unique_ID" type="text" class="input text-box" value="<?php if (isset($_GET["WordPressURL"])){echo $_GET["WordPressURL"]; } ?>" required="required" />
                    <div class="hint" style="display: none;">
                      Your token is required
                    </div>
                  </li>
                </ol>
                <input type="hidden" name="action" value="update" />
                <input type="hidden" name="page_options" value="Zartis_Unique_ID" />
                <div class="cent">
                  <button type="submit" class="btn save buttons a zar_next">Save and get started</button>
                </div>

              </fieldset>
          </form>
        </div>

      </div>
      <!-- END OF c8 -->

      <div class="c8">
        <div class="callout">
          <h3>How your jobs should look</h3>
          <p> This is how your jobs listing should look on your Wordpress site, when your HireHive account is setup and
            <strong>shortcode is added to your jobs page</strong>. The styling of jobs will also depend on the installed theme.</p>
          <img src="https://zartis.blob.core.windows.net/public-screens/Wordpress-Jobs-Listing.png" />
        </div>
      </div>
      <!-- END OF c8 -->
    </div>
    <!-- END OF main -->
  </div>
  <!-- END OF wrap -->
</div>
<!-- END OF body-->