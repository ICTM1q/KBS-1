<?php if ($total > $limit){?>
<div class="row">
    <div class="offset-5 col-md-5">
        <ul class="pagination">
            <?php $count = 0;
            for($i = 0;$i < $total; $i += 10){  $count++;?>

                <li class="page-item <?php if(isset($_GET['page']) &&$_GET['page'] == $count) { echo "active";}elseif(!isset($_GET['page']) && $count == 1){ echo "active"; } ?>">
                    <a class="page-link" href="?page=<?php echo ($count); ?>"><?php echo $count; ?></a>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>
<?php } ?>