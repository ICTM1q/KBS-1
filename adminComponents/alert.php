<?php
/**
 * Created by PhpStorm.
 * User: Tristan Willems
 * Date: 28-11-2017
 * Time: 14:56
 */
?>
<div class="row modified-topoffset">
    <div class="col-md-12">
    <?php if (isset($_SESSION['message']) &&$_SESSION['message'] != null){ ?>
        <div class="alert alert-success custom-col" role="alert">
            <?php echo $_SESSION['message']; $_SESSION['message'] = null; unset($_SESSION['message']);?>
        </div>
    <?php }
    if (isset($_SESSION['error']) && $_SESSION['error'] != null){ ?>
        <div class="alert alert-danger custom-col" role="alert">
            <?php echo $_SESSION['error']; $_SESSION['error'] = null; unset($_SESSION['error']); ?>
        </div>
    <?php }
    if (isset($_SESSION['warning']) && $_SESSION['warning'] != null){ ?>
        <div class="alert alert-warning custom-col" role="alert">
            <?php echo $_SESSION['warning']; $_SESSION['warning'] = null; unset($_SESSION['warning']);?>
        </div>
    <?php }
    ?>
    </div>
</div>