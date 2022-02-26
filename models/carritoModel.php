<?php
    class Carrito{
        private $tipo_consulta;
        private $inicio_pagina;
        private $fin_pagina;
        private $filtros;
        private $cod_usuario;
        private $data1;
        private $data2;
        private $data3;
        private $data4;
        private $data5;
        private $data6;
        private $data7;
        private $data8;
        private $data9;
        private $data10;

        function __construct($tipo_consulta,$inicio_pagina = 0 ,$fin_pagina = 0,$filtros = '',$cod_usuario = '',$data1 = '',$data2 = '',$data3 = '',$data4 = '',$data5 = '') {
            $this->tipo_consulta    = $tipo_consulta;
            $this->inicio_pagina    = $inicio_pagina;
            $this->fin_pagina       = $fin_pagina;
            $this->filtros          = $filtros;
            $this->cod_usuario      = $cod_usuario;
            $this->data1            = $data1;
            $this->data2            = $data2;
            $this->data3            = $data3;
            $this->data4            = $data4;
            $this->data5            = $data5;
        }

        public function setTipoConsulta($tipo_consulta){
            $this->tipo_consulta = $tipo_consulta;
        }
        public function setFiltros($filtros){
            $this->filtros = $filtros;
        }
        public function setData1($data1){
            $this->data1 = $data1;
        }
        public function setData2($data2){
            $this->data2 = $data2;
        }
        public function setData3($data3){
            $this->data3 = $data3;
        }
        public function setData4($data4){
            $this->data4 = $data4;
        }
        public function setData5($data5){
            $this->data5 = $data5;
        }
        public function setData6($data6){
            $this->data6 = $data6;
        }

        public function setData7($data7){
            $this->data7 = $data7;
        }
        public function setData8($data8){
            $this->data8 = $data8;
        }
        public function setData9($data9){
            $this->data9 = $data9;
        }

        public function serverQuery($conexionx){
            $call_procedure ="Call sp_carrito(?,?,?,?,?,?,?,?,?,?)";
            $stmt_class = $conexionx->prepare($call_procedure);
            $stmt_class->execute(array(
                            $this->tipo_consulta, 
                            $this->inicio_pagina,
                            $this->fin_pagina,
                            $this->filtros,
                            $this->cod_usuario,
                            $this->data1,
                            $this->data2,
                            $this->data3,
                            $this->data4,
                            $this->data5
                        ));
            return $stmt_class;
        }
    }
?>