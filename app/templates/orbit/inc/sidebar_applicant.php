<div class="navigationbar">
    <ul class="vertical-menu">
       <!--  <li>
            <a href="javaScript:void();">
              <img src="<?php echo _vendor('images/svg-icon/dashboard.svg')?>" class="img-fluid" alt="dashboard"><span>Dashboard</span>
            </a> 
        </li>
        <li>
            <a href="javaScript:void();">
              <img src="<?php echo _vendor('images/svg-icon/dashboard.svg')?>" class="img-fluid" alt="dashboard"><span>Job Applications</span>
            </a> 
        </li>

        <li>
            <a href="javaScript:void();">
              <img src="<?php echo _vendor('images/svg-icon/dashboard.svg')?>" class="img-fluid" alt="dashboard"><span>Saved Jobs</span>
            </a> 
        </li> -->

        <?php if(auth()['done_setup']):?>
        <li>
            <a href="profile.php">
              <img src="<?php echo _vendor('images/svg-icon/dashboard.svg')?>" class="img-fluid" alt="dashboard"><span>Profile</span>
            </a> 
        </li>

       <li>
            <a href="education_primary_edit.php">
              <img src="<?php echo _vendor('images/svg-icon/dashboard.svg')?>" class="img-fluid" alt="dashboard"><span>Education</span>
            </a> 
        </li>

        <li>
            <a href="work_history_edit.php">
              <img src="<?php echo _vendor('images/svg-icon/dashboard.svg')?>" class="img-fluid" alt="dashboard"><span>Work History</span>
            </a> 
        </li>

        <li>
            <a href="skills_edit.php">
              <img src="<?php echo _vendor('images/svg-icon/dashboard.svg')?>" class="img-fluid" alt="dashboard"><span>Skills</span>
            </a> 
        </li>

         <li>
            <a href="contact_edit.php">
              <img src="<?php echo _vendor('images/svg-icon/dashboard.svg')?>" class="img-fluid" alt="dashboard"><span>Contact</span>
            </a> 
        </li>

        <li>
            <a href="catalog.php">
              <img src="<?php echo _vendor('images/svg-icon/dashboard.svg')?>" class="img-fluid" alt="dashboard"><span>Catalog</span>
            </a> 
        </li>

        <li>
            <a href="appointment_list.php">
              <img src="<?php echo _vendor('images/svg-icon/dashboard.svg')?>" class="img-fluid" alt="dashboard"><span>Appointments</span>
            </a> 
        </li>

        <li>
            <a href="auth_edit.php">
              <img src="<?php echo _vendor('images/svg-icon/dashboard.svg')?>" class="img-fluid" alt="dashboard"><span>Logins</span>
            </a> 
        </li>
        <?php endif?>
        <li>
            <a href="logout.php">
              <img src="<?php echo _vendor('images/svg-icon/dashboard.svg')?>" class="img-fluid" alt="dashboard"><span>Logout</span>
            </a> 
        </li>
    </ul>
</div>