<?php
    namespace MCF7;
          
    class ContactoController
    {
    
        public function __construct()
        {
    
        }
        public static function guardar()
        {
            $args=[
                'post_type'     => 'mcf7_contacto',
                'post_title'    => $_POST['your-name'].' con email '.$_POST['your-email'],
                'post_status'   => 'draft',
                'meta_input'    => [
                    'nombre'    => $_POST['your-name'],
                    'email'     => $_POST['your-email'],
                    ]
            ];
            wp_insert_post($args);
        }
        function TablaColumnas($defaults)
        {
            unset($defaults['categories']);
            unset($defaults['date']);
            $defaults['nombre'] = "Nombre";
            $defaults['email']  = "Correo Electrónico";
            return $defaults;
        }

        function TablaColumnasContenido($column_name,$post_id)
        {
            if($column_name=='nombre')
            {
                echo get_post_meta($post_id,'nombre',true);
            }
            if($column_name=='email')
            {
                echo get_post_meta($post_id,'email',true);
            }

        }
        static function boton_ganador()
        {
            $html='<div class="ganador"></div><input type="button" id="boton-ganador" value="elige ganador" />
            <script type="text/javascript">
                var ajaxurl = "'.admin_url("admin-ajax.php").'";
                var data ={"action":"elegir_ganador"}
                jQuery(function($) {
                $("#boton-ganador").on("click",function(e){
                    $.post(ajaxurl, data, function(response) {
                        $(".ganador").text(response);
                    });
                });
                });
            </script>';
            return $html;
        }
        static function MostrarGanador()
        {	
            $query = new \WP_Query( 
            [ 
                'post_type'     => 'mcf7_contacto',
                'orderby'       => 'rand',
                'limit'			=> 1
            ] );
            die(($query->post->post_title));
        }
        public function AsignarOrdenacion($columns)
        {
            $columns['nombre'] = 'nombre_ord';

            return $columns;
        }
        public function OrdenarColumnas($request)
        {
            if ( isset( $request['post_type'] ) && 'mcf7_contacto' == $request['post_type'] ) {
                if ( isset( $request['orderby'] ) && 'nombre_ord' == $request['orderby'] ) {
                    $request = array_merge(
                        $request,
                        array(
                            'meta_key' => 'nombre',
                            'orderby' => 'meta_value'
                        )
                    );
                }
            }
			return $request;
        }

       
        
    }