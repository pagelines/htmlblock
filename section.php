<?php
/*
	Section: HTML Block
	Author: opportunex - Thomas Butler
	Author URI: http://opportunex.com
	Description: A simple box for adding HTML, includes a WYSIWYG editor from Redactor (http://imperavi.com/redactor/).
	Class Name: PLHTML_block
	Filter: component
	Loading: active
*/

class PLHTML_block extends PageLinesSection {
    
    function section_styles(){
        
        if( pl_draft_mode() ){
        
            wp_enqueue_style( 'redactor-css', $this->base_url.'/redactor.css');
            wp_enqueue_script( 'redactor-js',$this->base_url . '/redactor.min.js');
            wp_enqueue_script( 'livequery-js',$this->base_url . '/jquery.livequery.js');
        
        }
        
    }
    
    function section_opts(){
        
        $opts = array(
			array(
				'type'		=> 'multi',
				'key'		=> 'htmlblock_text', 
				'span'		=> 3,
				'opts'		=> array(
					array(
						'type' 			=> 'textarea',
						'key'			=> 'htmlblock_content',
						'label' 		=> __( 'HTML Block', 'html-block' ),
                        'help'      => __( "To modify raw HTML code click the &#60;&#47;&#62; button. Tags that are not allowed: 'html', 'head', 'link', 'body', 'meta'.  WordPress may also strip out a variety of HTML5 tags as well.", 'html-block' )
                    ),
					
				)
			), 
			array(
				'type'		=> 'multi',
				'key'		=> 'htmlblock_config', 
				'opts'		=> array(
					array(
						'key'			=> 'htmlblock_pad',
						'type' 			=> 'text',
						'label' 	=> __( 'Padding <small>(CSS Shorthand)</small>', 'pagelines' ),
						'ref'		=> __( 'This option uses CSS padding shorthand. For example, use "15px 30px" for 15px padding top/bottom, and 30 left/right.', 'html-block' ),
                    	
					),
					array(
						'type' 			=> 'select',
						'key'			=> 'htmlblock_align',
						'label' 		=> 'Alignment',
						'opts'			=> array(
							'textleft'		=> array('name' => 'Align Left (Default)'),
							'textright'		=> array('name' => 'Align Right'),
							'textcenter'	=> array('name' => 'Center'),
							'textjustify'	=> array('name' => 'Justify'),
						)
					),
					array(
						'type' 			=> 'select_animation',
						'key'			=> 'htmlblock_animation',
						'label' 		=> __( 'Viewport Animation', 'pagelines' ),
						'help' 			=> __( 'Optionally animate the appearance of this section on view.', 'html-block' ),
					),
					
				)
			),
			
			
			
		);

        return $opts;

    }
    
    function section_head(){
        
        if( pl_draft_mode() ){ ?>
        
		<script type="text/javascript">
        jQuery(document).ready(function() { 
            
            jQuery(".redactor_box").livequery("mouseleave", function(){ 
                if(jQuery(this).find(".redactor_btn_html").hasClass("redactor_act")) {
                    jQuery.optPanel.setBinding();
                } else {
                    jQuery(jQuery(this).find("#htmlblock_content")).redactor("sync");
                }
            });
                
                
            var buttons = ['html', '|', 'formatting', '|', 'bold', 'italic', 'underline', '|', 'unorderedlist', 'orderedlist', 'outdent', 'indent', '|', 'link', '|', 'fontcolor', 'backcolor', '|', 'alignment', '|', 'horizontalrule', '|', 'alignleft', 'aligncenter', 'alignright', 'justify'];
            var denieds = ['html', 'head', 'link', 'body', 'meta'];
        
            var timerId = setTimeout(function() {
                jQuery(".opt-htmlblock_text textarea").redactor({ focus: true, buttons: buttons, deniedTags: denieds, autoresize: false, minHeight: 350 }); 
                jQuery(".redactor_box").addClass("lstn");
                jQuery.optPanel.setBinding();
                jQuery.optPanel.setPanel();
            }, 500);
            
        });
        </script>
        
		<?php }

	}

	function section_template() {

		$id = $this->get_the_id();
        
        $html = $this->opt('htmlblock_content');

		$html = (!$html) ? '<p><strong>HTML Block</strong> &raquo; Add Your Content!</p>' : sprintf('<div class="hentry">%s</div>', $html ); 
		
		$class = $this->opt('htmlblock_animation');
			
		$align = $this->opt('htmlblock_align');
		
		$pad = ($this->opt('htmlblock_pad')) ? sprintf('padding: %s;', $this->opt('htmlblock_pad')) : ''; 
		
		printf('<div class="htmlblock-wrap pl-animation %s %s" style="%s">%s</div>', $align, $class, $pad, $html);

	}
}
