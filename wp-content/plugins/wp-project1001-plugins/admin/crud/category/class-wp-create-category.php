<?php

global $wpdb;

$set_name_pj = "pj1001_";

$table_name = $wpdb->prefix . $set_name_pj . "category";

date_default_timezone_set('Asia/Ho_Chi_Minh');

?>

<div class="wrap">
    <div class="container">
        <div class="wrap-page" type="wrap-mini-form create-category">
            <div class="wrap-header">
                <h2><?php _e('Thêm mới thể loại', 'category') ?></h2>
            </div>
            <form action="<?php echo admin_url('admin.php?page=create_category') ?>" class="form form-action-admin" id="form-plugin-create-category" enctype="multipart/form-data">
                <div class="field">
                    <label class="form-label">Thể Loại</label>
                    <input type="text" name="name_category" placeholder="Nhập tên thể loại">
                </div>
                <div class="field">
                    <label class="form-label">Nội Dung</label>
                    
                </div>
            </form>
        </div>
    </div>
</div>

<?php

?>