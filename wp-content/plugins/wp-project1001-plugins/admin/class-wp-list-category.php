<?php

/**
 * Plugin Name: wp-project1001-plugins
 * Plugin URI: wp-project1001-plugins/plugin.php
 * Description: Tạo trang danh sách thể loại
 * Author: unsersea
 * Plugin Version: v1.0
 */

// WP List Table

if (!class_exists("WP_List_Table")) {
    require_once (ABSPATH . "wp-admin/includes/class-wp-list-table.php");
}

/**
 * WP List Category
 */

// Check is_admin()

// if (is_admin()) {
//     return WP_Form_Category();
// }

class WP_Custom_Category extends WP_List_Table
{
    /**
     * Constructor give some basic params
     */
    public function __construct()
    {
        // global $status, $page
        parent::__construct(
            array(
                'singular' => 'category',
                'plural' => 'category',
                'ajax' => true
            )
        );
    }

    /**
     * Column default
     */
    public function column_default($item, $column_name)
    {
        switch ($item[$column_name]) {
            case '0':
                return '0';
            case '1':
                return '1';
            default:
                return $item[$column_name];
        }
    }

    /**
     * Column id
     */
    public function column_id($item)
    {
        $action = array(
            'update' => sprintf('
                <a class="btn btn-wp-list-table-action btn-info text-white" data-id="%s" id="btn-update-category">
                    <i class="bx bx-edit-alt"></i>
                </a>
            ', $item['id']),

            'delete' => sprintf('
                <a class="btn btn-wp-list-table-action btn-danger text-white" data-id="%s" id="btn-delete-category">
                    <i class="bx bx-trash"></i>
                </a>
            ', $item['id']),

            'detail' => sprintf('
                <a class="btn btn-wp-list-table-action btn-warning text-white" data-id="%s" id="btn-detail-category">
                    <i class="bx bx-detail"></i>
                </a>
            ', $item['id'])
        );

        return sprintf('%s %s', $item["id"], $this->row_actions($action));
    }

    /**
     * Column cb
     */
    public function column_cb($item)
    {
        return sprintf('<input type="checkbox" name="id[]" value="%s" />', $item["id"]);
    }

    /**
     * Get columns
     */
    public function get_columns()
    {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'id' => __('#', 'category'),
            'name_category' => __('Thể Loại', 'category'),
            'content' => __('Nội Dung', 'category'),
            'create_at' => __('Ngày Tạo', 'category'),
        );

        return $columns;
    }

    /**
     * Get sortable columns
     */
    public function get_sortable_columns()
    {
        $sortable_columns = array(
            'id' => array('id', true),
        );

        return $sortable_columns;
    }

    /**
     * Get bulk actions
     */
    public function get_bulk_actions()
    {
        $actions = array(
            'delete' => 'Xoá'
        );

        return $actions;
    }

    /**
     * Process bulk action
     */
    public function process_bulk_action()
    {
        global $wpdb;

        $set_name_pj = "pj1001_";

        $table_name = $wpdb->prefix . $set_name_pj . "category";

        if ('delete' === $this->current_action()) {
            $ids = isset ($_REQUEST['id']) ? $_REQUEST['id'] : array();

            if (is_array($ids))
                $ids = implode(',', $ids);

            if (!empty ($ids)) {
                $wpdb->query("DELETE FROM $table_name WHERE id IN($ids)");
            }
        }
    }

    /**
     * Prepare items
     */
    public function prepare_items()
    {
        global $wpdb;

        $set_name_pj = "pj1001_";

        $table_name = $wpdb->prefix . $set_name_pj . "category";

        $per_page = 10;
        $columns = $this->get_columns();
        $hidden = array();

        $sortable = $this->get_sortable_columns();

        // Cofigure Table Headers, Defined in Out
        $this->_column_headers = array($columns, $hidden, $sortable);

        // Process Bulk Action If Any
        $this->process_bulk_action();

        // Will Be Use Pagination Settings
        $total_items = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");

        // Prepare Query Params, As Usual Page, Order By and Order Direction
        $paged = isset ($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;
        $orderby = (isset ($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'id';
        $order = (isset ($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'desc';

        if (isset ($_REQUEST['s']) && $_REQUEST['s'] != '') {
            $this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE `id` = '" . $_REQUEST['s'] . "' ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged * $per_page), ARRAY_A);
        } else {
            $this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged * $per_page), ARRAY_A);
        }

        $this->set_pagination_args(
            array(
                'total_items' => $total_items, // total items defined above
                'per_page' => $per_page, // per page constant defined at top of method
                'total_pages' => ceil($total_items / $per_page) // calculate pages count
            )
        );
    }
}

// add_action('wp_ajax_load_custom_table', 'WP_Form_Category');

function WP_Form_Category()
{
    // $obj = new WP_Custom_Category();
    // $obj->prepare_items();
    // // ob_start();
    //            ?>

    <div class="wrap">
        <h2 class="wp-heading-inline">
            <?php _e('Danh Sách Thể Loại', 'category') ?>
            <a class="page-title-action" data-id="" data-toggle="modal" data-target="#modal-create-category" href="#">Thêm
                Mới</a>
            <!-- <a class="page-title-action" href="<?php // echo admin_url('admin.php?page=create_category')               ?>">Thêm Mới</a> -->
        </h2>
        <form id="" method="GET" enctype="multipart/form-data">
            <input type="hidden" name="page" value="<?php // echo $_REQUEST['page'];            ?>">
            <div id="wp-list-table-category-container">
                <?php // $obj->display();            ?>
            </div>
        </form>
    </div>
    <?php
    // WP_Modal_Category();
    // // $table_html = ob_get_clean();
    // // echo $table_html;


    // // die();

}

function reload_wp_list_table_category_callback()
{
    $obj = new WP_Custom_Category();
    $obj->prepare_items();
    // ob_start();
    ?>

    <div class="wrap">
        <h2 class="wp-heading-inline">
            <?php _e('Danh Sách Thể Loại', 'category') ?>
            <a class="page-title-action" data-id="" data-toggle="modal" data-target="#modal-create-category" href="#">Thêm
                Mới</a>
            <!-- <a class="page-title-action" href="<?php // echo admin_url('admin.php?page=create_category');        ?>">Thêm Mới</a> -->
        </h2>
        <form id="" method="GET" enctype="multipart/form-data">
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page']; ?>">
            <div id="wp-list-table-category-container">
                <?php $obj->display(); ?>
            </div>
        </form>
    </div>
    <?php
    WP_Modal_Category();
    // $table_html = ob_get_clean();
    // echo $table_html;


    // wp_die();
}

// add_action('wp_ajax_my_ajax_action', 'reload_wp_list_table_category_callback');

function WP_Modal_Category()
{
    // global $wpdb;



    ?>
    <!-- Create Modal -->
    <div class="modal fade" id="modal-create-category" tabindex="-1" aria-labelledby="ex-modal-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="<?php // echo admin_url('admin.php?page=category');                ?>" method="POST"
                    class="form form-modal" enctype="multipart/form-data" id="form-create-category">
                    <div class="modal-header">
                        <h5 class="modal-title">Tạo Mới</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">
                                <i class="bx bx-x"></i>
                            </span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="field-modal">
                            <label class="form-label">Thể Loại</label>
                            <input type="text" name="category-name" class="form-control-dsg" placeholder="Nhập thể loại">
                            <div class="div-error" id="error-category-name"></div>
                        </div>
                        <div class="field-modal field-texta">
                            <label class="form-label">Nội Dung</label>
                            <textarea name="category-content" class="form-control-dsg" rows="3"
                                placeholder="Nhập nội dung"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary" id="submit-create-category">Lưu Thay Đổi</button>
                        <!-- <input type="submit" class="btn btn-primary" id="submit-create-category" name="action-modal" value="Lưu Thay Đổi"> -->
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Update Modal -->
    <div class="modal fade" id="modal-update-category" tabindex="-1" aria-labelledby="ex-modal-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="<?php // echo admin_url('admin.php?page=category');                ?>" method="POST"
                    class="form form-modal" enctype="multipart/form-data" id="form-update-category">
                    <div class="modal-header">
                        <h5 class="modal-title">Cập Nhật</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">
                                <i class="bx bx-x"></i>
                            </span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="field-modal">
                            <label class="form-label">Thể Loại</label>
                            <input type="text" name="category-name" class="form-control-dsg" placeholder="Nhập thể loại"
                                id="single-update-category-name">
                            <div class="div-error" id="error-category-name-update"></div>
                        </div>
                        <div class="field-modal field-texta">
                            <label class="form-label">Nội Dung</label>
                            <textarea name="category-content" class="form-control-dsg" rows="3"
                                id="single-update-category-content" placeholder="Nhập nội dung"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary" id="submit-update-category">Lưu Thay Đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <?php

    ?>
    <script type="text/javascript">

        jQuery(function ($) {

            // load table
            function load_table_category() {
                // $.ajax({
                //     url: ajaxurl, // WordPress AJAX URL
                //     type: 'GET',
                //     data: {
                //         action: 'load_wp_list_table_form' // AJAX action to handle
                //         // Additional parameters can be added here if needed
                //     },
                //     success: function (response) {
                //         // Update the table container with the response
                //         $('#wp-list-table-category-container').html(response);
                //     },
                //     error: function (xhr, status, error) {
                //         console.error(xhr.responseText);
                //     }
                // });
            }

            // modal category
            function modal_category() {
                // Create Form
                $("#submit-create-category").click(function (e) {
                    e.preventDefault();

                    // Get Form Value
                    var form_element = document.getElementById("form-create-category");

                    var elements = form_element.elements;

                    var values = {};

                    for (var i = 0; i < elements.length; i++) {
                        var element = elements[i];

                        // Check if the element has a name (to exclude submit buttons, etc.)
                        if (element.name) {
                            // Add the element's value to the object using the name as the key
                            values[element.name] = element.value;
                        }
                    }

                    // console.log("Form values:", values);
                    var category_name_value = values["category-name"];
                    var category_content_value = values["category-content"];

                    // error
                    var error_category_name = document.querySelector("#form-create-category #error-category-name");

                    if (category_name_value === '') {
                        error_category_name.innerHTML = "*Bạn chưa nhập tên thể loại!";
                    } else {
                        // set empty error
                        error_category_name.innerHTML = "";

                        // Form Data
                        // var formData = new FormData(jQuery(form_element)[0]);

                        $.ajax({
                            type: "POST",
                            url: "<?php echo plugin_dir_url(__FILE__) . 'controller/CategoryController.php' // admin_url('../admin/controller/CategoryController.php')               ?>",
                            data: {
                                category: category_name_value,
                                content: category_content_value,
                                action: "submit-create-category",
                            },
                            // data: formData,
                            // contentType: false,
                            // processData: false,
                            success: function (data) {
                                jQuery("#modal-create-category").modal('hide');

                                jQuery("#form-create-category")[0].reset();

                                // Load WP List Table
                                // load_table_category();

                                // Load Page
                                location.reload();
                            },
                        });
                    }
                });

                // Update Form
                $("#wp-list-table-category-container").on("click", "#btn-update-category", function (e) {
                    var data_id = $(this).data("id");

                    // Find Id
                    $.ajax({
                        type: "POST",
                        url: "<?php echo plugin_dir_url(__FILE__) . 'controller/CategoryController.php' ?>",
                        data: {
                            id: data_id,
                            action: "find-category",
                        },
                        success: function (data) {
                            var response = JSON.parse(data);
                            // Open Modal
                            // *Slow Response
                            jQuery("#modal-update-category").modal("show");

                            // Add Data in Input Value
                            $("#single-update-category-name").val(response.name_category);
                            $("#single-update-category-content").val(response.content);

                        }
                    });
                });
                // Delete Form
            }

            modal_category();
        });

    </script>

    <?php
}

// WP_Form_Category();

reload_wp_list_table_category_callback();
