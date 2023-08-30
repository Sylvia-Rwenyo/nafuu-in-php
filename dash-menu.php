<div class="dash-menu">
    <ul>
        <?php  
        // determine target page based on user category
        $current_user_id = $_SESSION['id'];
        if ($_SESSION['category'] == 'hospital') {
            ?>
            <!-- trends -->
            <a href="<?php echo prefixSet('dashboard.php')?>" class="<?php echo isActive('dashboard.php'); ?>"><li><i class="fa-solid fa-chart-line"></i></li></a>
            <!-- add new doctor -->
            <a href="<?php echo prefixSet('partners/add-doctor.php')?>" class="<?php echo isActive('partners/add-doctor.php'); ?>"><li><i class="fa-solid fa-add"></i></li></a>

            <!-- records -->
            <a href="<?php echo prefixSet('partners/doctor-records.php')?>" class="<?php echo isActive('partners/doctor-records.php'); ?>"><li><i class="fa-solid fa-folder"></i></li></a>
            <!-- settings -->
            <a href="<?php echo prefixSet('settings.php')?>" class="<?php echo isActive('settings.php'); ?>"><li><i class="fa-solid fa-gears"></i></li></a>

            <!-- patient-doctor chats -->
            <?php
        } else if ($_SESSION['category'] == 'doctor') {
            ?>
            <!-- trends -->
            <a href="<?php echo prefixSet('dashboard.php')?>" class="<?php echo isActive('dashboard.php'); ?>"><li><i class="fa-solid fa-chart-line"></i></li></a>
            <!-- add records -->
            <a href="<?php echo prefixSet('doctors/add-patient.php')?>" class="<?php echo isActive('doctors/add-patient.php'); ?>"><li><i class="fa fa-plus"></i></li></a>
            <!-- existing records -->
            <a href="<?php echo prefixSet('patient-records.php')?>" class="<?php echo isActive('patient-records.php'); ?>"><li><i class="fa-solid fa-folder"></i></li></a>
            <!-- schedule appointment -->
            <a href="<?php echo prefixSet('calendar.php')?>"><li>                
                <?php
                $id = $_SESSION['id'];
                $today = new DateTime(); // Get the current date and time
                $today->setTime(0, 0, 0); // Set the time to the beginning of the day (midnight)
                $today_formatted = $today->format('Y-m-d');
                $appointment = mysqli_query($conn,"SELECT * FROM appointments WHERE appointmentDate = '$today_formatted'");
                $count = 0;
                while($row = mysqli_fetch_array($resultPost)) 
                {
                    if($row['readStatus'] == 'unread')
                    {
                        $count = $count + 1;
                    }
                }?>
                <i class="fa fa-calendar"><span class="badge"><?php if($count == 0){echo "";}else{echo $count;}?></span></i></li></a>
            <!-- settings -->
            <a href="<?php echo prefixSet('settings.php')?>"><li><i class="fa-solid fa-gears"></i></li></a>
            <?php
        } else {
            ?>
            <!-- trends -->
            <a href="<?php $prefix_set="dashboard.php?id='$current_user_id'"; echo prefixSet($prefix_set);?>" class="<?php echo isActive('dashboard.php'); ?>"><li><i class="fa-solid fa-chart-line"></i></li></a>
            <!-- records -->
            <a href="<?php echo prefixSet('patient-log.php')?>" class="<?php echo isActive('records.php'); ?>"><li><i class="fa-solid fa-folder"></i></li></a>
            <!-- see set appointments or request to set one -->
            <a href="<?php echo prefixSet('calendar.php')?>"><li><i class="fa fa-calendar"></i></li></a>
            <!-- settings -->
            <a href="<?php echo prefixSet('settings.php')?>"><li><i class="fa-solid fa-gears"></i></li></a>
            <?php
        }
        ?>
    </ul>
</div>
