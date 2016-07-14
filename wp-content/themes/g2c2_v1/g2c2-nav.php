<style type="text/css">
.art-comments h2,
.art-commentsform h2 {
  font-size: 20px;
}
.navbar-header {
  width: 100%;
}
@media (min-width: 768px) {
  .navbar-header {
    width: auto;
  }
}
</style>

<nav class="membernav navbar navbar-fixed-top" role="navigation">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <img src="<?php echo get_bloginfo('template_directory');?>/icon-mobile-nav.png" width="32px" />
          </button>
          <a class="navbar-brand" href="<?php echo site_url(); ?>/?page_id=22"><img src="<?php echo get_bloginfo('template_directory');?>/g2c2-member-logo.png" /></a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="nav-li-1">
              <a href="<?php echo site_url(); ?>/?page_id=22">Home</a>
            </li>
            <li class="nav-li-2">
              <a href="<?php echo site_url(); ?>/?page_id=24">Networking &amp; Conferences</a>
              </li>
            <li class="nav-li-3">
              <a href="<?php echo site_url(); ?>/?page_id=28">Education &amp; Outreach</a>
            </li>
            <li class="nav-li-4">
              <a href="<?php echo site_url(); ?>/?page_id=26">Funding Opportunities</a>
            </li>
          
          </ul>

	  <div class="navbar-right btn btn-primary memberspage-logout" style="margin: 12px 12px 12px 42px; padding: 9px"><?php wp_loginout( "http://www.greenchemistrynetwork.org", true ); ?></div>

    <?php global $current_user;
          get_currentuserinfo(); ?>
    <div class="navbar-right" style="margin: 6px 15px">
	Welcome, <?php echo $current_user->user_firstname; ?>!
	<br />
	<a class="small membernav-link" href="<?php echo site_url(); ?>">Go to public homepage</a>
    </div>


        </div><!--/.nav-collapse -->
    </nav>
