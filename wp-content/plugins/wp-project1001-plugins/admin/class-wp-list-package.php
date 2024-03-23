<?php

/**
 * Plugin Name: wp-project1001-plugins
 * Plugin URI: wp-project1001-plugins/plugin.php
 * Description: Tạo trang danh sách loại gói
 * Author: unsersea
 * Plugin Version: v1.0
 */

// WP List Table
if (!class_exists("WP_List_Table")) {
    require_once(ABSPATH . "wp-admin/includes/class-wp-list-table.php");
}

/**
 * WP List Package
 */

// Check is_admin()

if (is_admin()) {
    return 0;
}

class WP_Custom_Package extends WP_List_Table
{
    /**
     * Constructor give some basic params
     */
    public function __construct()
    {
        // global $status, $page
        parent::__construct(
            array(
                'singular' => 'package',
                'plural' => 'package',
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
            'delete' => sprintf(''),
            'update' => sprintf(''),
            'detail' => sprintf('')
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

        $table_name = $wpdb->prefix . $set_name_pj . "package";

        if ('delete' === $this->current_action()) {
            $ids = isset($_REQUEST['id']) ? $_REQUEST['id'] : array();

            if (is_array($ids))
                $ids = implode(',', $ids);

            if (!empty($ids)) {
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

        $table_name = $wpdb->prefix . $set_name_pj . "package";

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
        $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;
        $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'id';
        $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'desc';

        if (isset($_REQUEST['s']) && $_REQUEST['s'] != '') {
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

function WP_Form_Package()
{
    $obj = new WP_Custom_Package();
    $obj->prepare_items();
    ?>
    <div class="wrap">
        <h2 class="wp-heading-inline">
            <?php _e('', 'package') ?> <a class="page-title-action" href="<?php echo admin_url(''); ?>">Thêm Mới</a>
        </h2>
        <form id="" method="GET" enctype="multipart/form-data">
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page']; ?>">
            <?php $obj->display(); ?>
        </form>
    </div>
    <?php
}