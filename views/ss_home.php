<?php 
    class APF_Tutorial_SidePageMetaBox extends AdminPageFramework_PageMetaBox {
        
    /*
     * Use the setUp() method to define settings of this meta box.
     */
    public function setUp() {
    
        /**
         * Adds setting fields in the meta box.
         */
        $this->addSettingFields(
            array(
                'field_id'          => 'tutorial_page_metabox_color',
                'type'              => 'color',
                'title'             => __( 'Color', 'admin-page-framework-tutorial' ),
            ),        
            array(
                'field_id'          => 'tutorial_metabox_text_field',
                'type'              => 'text',
                'title'             => __( 'Text Input', 'admin-page-framework-tutorial' ),
            ),
            array(
                'field_id'          => 'submit_in_page_meta_box',
                'type'              => 'submit',
                'show_title_column' => false,
                'label_min_width'   => '',
                'attributes'        => array(
                    'field' => array(
                        'style' => 'float:right; width:auto;',
                    ),                   
                ),
            )
        );     
        
        // content_{page slug}_{tab slug}
        add_filter( 'content_my_tabs_my_tab_c', array( $this, 'replyToInsertContents' ) );
        
    }
        
    /**
     * @callback    filter      content_{page slug}_{tab slug}
     * @return      string
     */
    public function replyToInsertContents( $sContent ) {
        
        $_aOptions  = get_option( 'APF_Tabs', array() );
        return $sContent 
            . "<h3>" . __( 'Saved Options', 'admin-page-framework-tutorial' ) . "</h3>"
            . AdminPageFramework_Debug::getArray( $_aOptions );
        
    }
 
    /**
     * The content filter callback method.
     * 
     * Alternatively use the `content_{instantiated class name}` method instead.
     * @return      string
     */
    public function content( $sContent ) {
        
        $_sInsert   = "<p>" . sprintf( __( 'This text is inserted with the <code>%1$s</code> method.', 'admin-page-framework-tutorial' ), __FUNCTION__ ) . "</p>";
        return $sContent;
        
    }
   
}
 
new APF_Tutorial_SidePageMetaBox(
    null,                                           // meta box id - passing null will make it auto generate
    __( 'Side Page Meta Box', 'admin-page-framework-tutorial' ), // title
    'my_tabs',
    'side',                                         // context
    'default'                                       // priority
);
 ?>