<?php
/**
 * Created by PhpStorm.
 * User: Tristan Willems
 * Date: 5-12-2017
 * Time: 12:19
 */?>
<div class="row">
    <div class="offset-5 col-md-5">
        <ul class="pagination">
            <?php $count = 0;
            for($i = 0;$i < $total; $i += 10){  $count++;?>

                <li class="page-item <?php if(isset($_GET['page']) &&$_GET['page'] == $count) { echo "active";} ?>">
                    <a class="page-link" href="?page=<?php echo ($count); ?>"><?php echo $count; ?></a></li>
            <?php } ?>
        </ul>
    </div>
</div>