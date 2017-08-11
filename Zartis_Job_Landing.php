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

    <!-- Main Content  -->
    <div id="main" role="main">

      <ul class="tabs">
        <li><a href="#tab1" title="HireHive Plugin Home">Home</a></li>
        <li><a href="#tab2" title="HireHive settings">Settings</a></li>
        <li><a href="#tab3" title="HireHive FAQs">FAQs</a></li>
        <li><a href="#tab4" title="HireHive advanced options">Extras</a></li>
      </ul>

      <div class="tab_container">

        <!-- HOME -->
        <div id="tab1" class="tab_content">
          <div class="flex">
            <div class="c9">
              <div class="content">
                <h2>You're all set!</h2>
                <p>Now all you need to do is create a new page and insert the
                  <strong>shortcode</strong> below. This will add a fully functioning jobs listing to your site.</p>

                <div class="callout code">
                  <code>[hirehive_jobs]</code>
                  <small>This will display all your published jobs</small>
                </div>
                <h2>Custom job groups</h2>
                <p>Create custom groups of your jobs if you wish to display jobs for different locations/categories on multiple pages</p>
                <div class="callout">

                  <h3>List of available HireHive groups you have</h3>
                  <select name="hirehive-categories" id="hirehive-categories">
                    <?php
$Company_Zartis_ID = get_option('Zartis_Unique_ID');
$url = 'https://my.hirehive.io/api/v2/public/search?cname=' .$Company_Zartis_ID;

$jsondata = file_get_contents($url);

$obj = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $jsondata), true);

$groups =  $obj;

$categories = array();
foreach ($groups as $group) {
    foreach ($group["jobs"] as $job) {
        $jobCategory = $job["category"];
        if ($jobCategory != null){
            if(!in_array($jobCategory, $categories)){
                $categories[] = $jobCategory;
            }
        }
    }
}

foreach( $categories as $category ) {
    echo '<option value="'.$category.'">'.$category.'</option>';
}

?>

                  </select>
                  <div class="callout code">
                    <code id="hh-code">[hirehive_jobs]</code>
                  </div>
                </div>

                <p>Below is what it should look like in your publish page.</p>
                <a href="https://zartis.blob.core.windows.net/public-screens/Plugin-Shortcode.jpg" class="hirehive-pic">
                  <img src="https://zartis.blob.core.windows.net/public-screens/Plugin-Shortcode.jpg" title="Just insert [hirehive_jobs] into any page you wish" />
                </a>
                <br/>
                <br/>
              </div>
            </div>
            <!-- END OF c8 -->
            <div class="c6">
              <div class="callout">
                <h3>Here's what most people do with HireHive</h3>
                <ul class="list">
                  <li>
                    <a href="https://my.hirehive.io/#/jobs/create" title="Go to HireHive create job page" target='_blank' class="zar_a">
                      <strong>Add a job</strong>
                    </a>: This is the best way to get started. It's simple.</li>

                  <li>
                    <a href="https://my.hirehive.io/#/Settings/jobboards" target='_blank' title="" class="zar_a">
                      <strong>Share your job</strong>
                    </a>: Push your jobs out on major job boards.</li>

                  <li>
                    <a href="https://my.hirehive.io/#/Settings/team" target='_blank' title="Add teams to HireHice" class="zar_a">
                      <strong>Add your team</strong>
                    </a>: Invite members of your team to be part of the hiring process.</li>
                </ul>

                <div class="cent">
                  <a href="https://my.hirehive.io/#/jobs/create" target="_blank" class="btn btn-sm save buttons">
Add jobs to your website now
</a>
                  <p>
                    <em><small>You will be brought to my.hirehive.io</small></EM>
                  </p>

                </div>
                <!-- END OF cent -->
              </div>
            </div>
          </div>
          <!-- END OF c8 -->
        </div>
        <!-- END OF tab1 -->

        <!-- OPTIONS -->
        <div id="tab2" class="tab_content">
          <div class="flex">
            <div class="c9">
              <div class="content">
                <h2>Job settings</h2>

                <form method="post" action="options.php">
                  <?php
wp_nonce_field('update-options');
$ZarisGroup = get_option('Zartis_Group');
?>
                    <fieldset class="sm">
                      <ol>
                        <!-- Width  -->
                        <li>
                          <h3>Change how the jobs are displayed</h3>
                          <select name="Zartis_Group" id="hirehive-group">
                            <option value="1" <?php if($ZarisGroup=="1" ) echo "selected"; ?>>No grouping</option>
                            <option value="2" <?php if($ZarisGroup=="2" ) echo "selected"; ?>>Location</option>
                            <option value="3" <?php if($ZarisGroup=="3" ) echo "selected"; ?>>Category</option>
                          </select>
                        </li>
                      </ol>
                      <input type="hidden" name="action" value="update" />
                      <input type="hidden" name="page_options" value="Zartis_Group" />
                      <div class="cent">
                        <button type="submit" class="btn save buttons">
                          Save settings
                        </button>
                      </div>

                    </fieldset>
                </form>
              </div>
              <div class="content">


                <h3>Jobs preview</h3>
                <div id="jobs-1" class="hh-list" style="display:none;">
                  <a class="hh-list-row" href="#">
                    <span class="hh-list-title">My Job 1</span>
                    <span class="hh-list-location">Dublin, Ireland</span>
                    <span class="hh-list-type">Full Time</span>
                  </a>
                  <a class="hh-list-row" href="#">
                    <span class="hh-list-title">My Job 2</span>
                    <span class="hh-list-location">Dublin, Ireland</span>
                    <span class="hh-list-type">Full Time</span>
                  </a>
                  <a class="hh-list-row" href="#">
                    <span class="hh-list-title">My Job 3</span>
                    <span class="hh-list-location">Dublin, Ireland</span>
                    <span class="hh-list-type">Full Time</span>
                  </a>
                </div>

                <div id="jobs-2" class="hh-list" style="display:none;">
                  <h3 class="hh-list-cat">Ireland</h3>
                  <a class="hh-list-row" href="#">
                    <span class="hh-list-title">My Job 1</span>
                    <span class="hh-list-location">Dublin, Ireland</span>
                    <span class="hh-list-type">Full Time</span>
                  </a>
                  <a class="hh-list-row" href="#">
                    <span class="hh-list-title">My Job 2</span>
                    <span class="hh-list-location">Dublin, Ireland</span>
                    <span class="hh-list-type">Full Time</span>
                  </a>
                  <h3 class="hh-list-cat">France</h3>
                  <a class="hh-list-row" href="#">
                    <span class="hh-list-title">My Job 3</span>
                    <span class="hh-list-location">Paris, France</span>
                    <span class="hh-list-type">Full Time</span>
                  </a>
                </div>

                <div id="jobs-3" class="hh-list" style="display:none;">
                  <h3 class="hh-list-cat">Sales</h3>
                  <a class="hh-list-row" href="#">
                    <span class="hh-list-title">My Job 1</span>
                    <span class="hh-list-location">Dublin, Ireland</span>
                    <span class="hh-list-type">Full Time</span>
                  </a>
                  <a class="hh-list-row" href="#">
                    <span class="hh-list-title">My Job 2</span>
                    <span class="hh-list-location">Dublin, Ireland</span>
                    <span class="hh-list-type">Full Time</span>
                  </a>
                  <h3 class="hh-list-cat">Marketing</h3>
                  <a class="hh-list-row" href="#">
                    <span class="hh-list-title">My Job 3</span>
                    <span class="hh-list-location">Paris, France</span>
                    <span class="hh-list-type">Full Time</span>
                  </a>
                </div>

              </div>


            </div>
            <!-- END OF c8 -->
            <div class="c6">
              <div class="callout">
                <h3>Add a job</h3>
                <p>
                  Once you have added your shortcode to your page, you should add a job. Log in to HireHive, and create your new job. Your jobs will then appear on your WordPress site.</p>
                <div class="cent">
                  <a href="https://my.hirehive.io/#/jobs/create" target="_blank" class="btn btn-sm save buttons">
Add jobs to your website now
</a>
                  <p>
                    <em><small>You will be brought to my.hirehive.io</small></EM>
                  </p>

                </div>
                <!-- END OF cent -->
              </div>
              <!-- END OF c8 -->
            </div>
          </div>
        </div>


      </div>
      <!-- END OF tab2 -->


      <!-- FAQs -->
      <div id="tab3" class="tab_content">
        <div class="flex">
          <div class="c9">
            <div class="content">
              <h2>Frequently asked questions</h2>


              <h3>How much does HireHive cost?</h3>
              <p>You can choose a pricing plan that suits you. Whether you have three, five or fifty open positions we have the right plan for you.</p>
              <h3>Are there any additional fees?</h3>
              <p>There are no additional fees, we do not charge a ‘setup fee’ or have any hidden extras – you only pay the monthly subscription fee that you signed up for. And you can cancel at any time during the billing cycle.</p>
              <h3>Can I try it out for free?</h3>
              <p>Sure! We know decisions like this take time so we offer a 14 free trial. During this trial you can use all features of the software, get support and have as many users signed up from your company as you like.</p>
              <h3>We’re doing a lot of hiring and need extra jobs, is this possible?</h3>
              <p>Absolutely. If you think you need more job slots you can contact us on <a href="mailto:newjobs@hirehive.io">newjobs@hirehive.io</a>.</p>
              <h3>What does ‘active jobs’ really mean?</h3>
              <p>Active jobs are the number of jobs that you can accept applications for at any one time. Once you have finished hiring for one job you can close/archive this job and open a new one. All information relating to a closed/archived job is stored
                within the system so you don’t lose any information.</p>
              <h3>Can I switch plans?</h3>
              <p>Things change – we get that. So you can easily change plans when and if you need to. You next invoice will then be prorated depending on the number of days you were on each plan.</p>
              <h3>I’d like to speak to someone about HireHive</h3>

              <p>You can set up a talk to us by mailing us at <a href="mailto:help@hirehive.io">help@hirehive.io</a>.</p>



            </div>
          </div>
          <!-- END OF c8 -->
          <div class="c6">
            <div class="callout">
              <h3>Add a job</h3>
              <p>
                Once you have added your shortcode to your page, you should add a job. Log in to HireHive, and create your new job. Your jobs will then appear on your WordPress site.</p>
              <div class="cent">
                <a href="https://my.hirehive.io/#/jobs/create" target="_blank" class="btn btn-sm save buttons">
Add jobs to your website now
</a>
                <p>
                  <em><small>You will be brought to my.hirehive.io</small></EM>
                </p>

              </div>
              <!-- END OF cent -->
            </div>
            <!-- END OF c8 -->
          </div>
        </div>
      </div>
      <!-- END OF tab3 -->

      <!-- ADVANCED -->
      <div id="tab4" class="tab_content">
        <div class="flex">
          <div class="c9">
            <div class="content">
              <h2>Public jobs board</h2>
              <p>HireHive creates your very own public jobs board. You can share this link or embed it in your navigation. </p>
              <div class="callout code">
                <a href="https://my.hirehive.io/<?php echo get_option('Zartis_Unique_ID'); ?>/" target="_blank">my.hirehive.io/<?php echo get_option('Zartis_Unique_ID'); ?></a>
              </div>

              <p>You can also customise this page by visiting <a href="https://my.hirehive.io/#/Settings/Careerpage" target="_blank">Customise settings</a> in HireHive. Easily add your company logo, upload images and change colours.</p>
              <div class="cent">
                <a href="https://my.hirehive.io/#/Settings/Careerpage" target="_blank" class="btn save buttons">
Customise your careers site
</a>
                <p>
                  <em><small>You will be brought to my.hirehive.io</small></EM>
                </p>
              </div>

              <br/>
              <br/>


            </div>
          </div>
          <!-- END OF c8 -->
          <div class="c6">
            <div class="callout">
              <h3>Add a job</h3>
              <p>
                Once you have added your shortcode to your page, you should add a job. Log in to HireHive, and create your new job. Your jobs will then appear on your WordPress site.</p>
              <div class="cent">
                <a href="https://my.hirehive.io/#/jobs/create" target="_blank" class="btn btn-sm save buttons">
Add jobs to your website now
</a>
                <p>
                  <em><small>You will be brought to my.hirehive.io</small></EM>
                </p>
              </div>
              <!-- END OF cent -->
            </div>
            <!-- END OF c8 -->
          </div>
        </div>
      </div>

    </div>
    <!-- END OF tab4 -->


  </div>
  <!-- END OF tab Containter -->

</div>
<!-- END OF main -->
</div>
<!-- END OF wrap -->
</div>
<!-- END OF zar_body-->