-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-02-2022 a las 18:22:48
-- Versión del servidor: 10.4.21-MariaDB
-- Versión de PHP: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pclink`
--

DELIMITER $$
--
-- Procedimientos
--
DROP PROCEDURE IF EXISTS `sp_carrito`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_carrito` (IN `tipo_consulta` LONGTEXT, IN `init_value` INT, IN `limit_value` INT, IN `filtros` LONGTEXT, IN `id_usuario` LONGTEXT, IN `dato1` LONGTEXT, IN `dato2` LONGTEXT, IN `dato3` LONGTEXT, IN `dato4` LONGTEXT, IN `dato5` LONGTEXT)  BEGIN
	DECLARE statment VARCHAR(25555);
    DECLARE CODIGO INT;
	-- MANEJO DE EXCEPCIONES
	DECLARE EXIT HANDLER FOR 1062 SELECT 'El registro ya se encuentra repetio' Mensaje, -1 codigo; 
    DECLARE EXIT HANDLER FOR 1054 SELECT 'Error al mencionar el campo de una tabla' Mensaje, -1 codigo; 
    DECLARE EXIT HANDLER FOR SQLEXCEPTION SELECT 'Ocurrio un error en el servidor' Mensaje, -1 codigo;
    DECLARE EXIT HANDLER FOR SQLSTATE '23000' SELECT 'Error de código en el servidor' Mensaje, -1 codigo;
    
    IF tipo_consulta = 'getItems'
    THEN
		SELECT p.nom_producto, p.imagen_producto, a.cantidad,a.id,p.precio
        FROM PCLINK.TMP_CARRITO a
        INNER JOIN PCLINK.productos p on a.cod_producto = p.id
        WHERE a.COD_USUARIO = id_usuario and a.st_item = 'A';
    END IF;
    
    IF tipo_consulta = 'getTotal'
    THEN
		SELECT sum(A.cantidad * P.precio) total 
        FROM PCLINK.TMP_CARRITO A
        INNER JOIN PCLINK.PRODUCTOS P ON P.ID = A.COD_PRODUCTO
		WHERE a.COD_USUARIO = id_usuario and a.st_item = 'A';
    END IF;
    
    IF tipo_consulta = 'getTotalitems'
    THEN
		SELECT sum(cantidad) total 
        FROM PCLINK.TMP_CARRITO a
		WHERE COD_USUARIO = id_usuario and st_item = 'A';
    END IF;
    
	IF tipo_consulta = 'add_carrito'
    THEN
		IF EXISTS(SELECT * FROM PCLINK.TMP_CARRITO WHERE COD_PRODUCTO = dato1 AND COD_USUARIO = id_usuario)
        THEN
			select -1 codigo;
        ELSE
			INSERT INTO PCLINK.TMP_CARRITO(COD_PRODUCTO, CANTIDAD, COD_USUARIO)
										VALUES(dato1,1,id_usuario);          
			select 200 codigo;
        END IF;
	END IF;
    
    IF tipo_consulta = 'actualizar_carrito'
    THEN
		IF EXISTS(SELECT * FROM PCLINK.TMP_CARRITO WHERE ID = dato1 AND COD_USUARIO = id_usuario)
        THEN
			UPDATE PCLINK.TMP_CARRITO
            SET 
				CANTIDAD = dato2
			WHERE
				ID = dato1
			AND
				COD_USUARIO = ID_USUARIO;
			select 200 codigo;
        ELSE
			select -1 codigo, dato1, id_usuario, dato2;
        END IF;
	END IF;
    
    IF tipo_consulta = 'delete'
    THEN
		DELETE FROM PCLINK.TMP_CARRITO WHERE ID = filtros;
        select 200 codigo;
    END IF;
    
    IF tipo_consulta = 'vaciar'
    THEN
		DELETE FROM PCLINK.TMP_CARRITO WHERE COD_USUARIO = id_usuario;
        select 200 codigo;
    END IF;
END$$

DROP PROCEDURE IF EXISTS `sp_categoria`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_categoria` (IN `tipo_consulta` LONGTEXT, IN `init_value` INT, IN `limit_value` INT, IN `filtros` LONGTEXT, IN `dato1` LONGTEXT, IN `dato2` LONGTEXT, IN `dato3` LONGTEXT, IN `dato4` LONGTEXT, IN `dato5` LONGTEXT, IN `dato6` LONGTEXT)  BEGIN
	DECLARE statment VARCHAR(25555);
	-- MANEJO DE EXCEPCIONES
	DECLARE EXIT HANDLER FOR 1062 SELECT 'El registro ya se encuentra repetio' Mensaje, -1 codigo; 
    DECLARE EXIT HANDLER FOR 1054 SELECT 'Error al mencionar el campo de una tabla' Mensaje, -1 codigo; 
    DECLARE EXIT HANDLER FOR SQLEXCEPTION SELECT 'Ocurrio un error en el servidor' Mensaje, -1 codigo;
    DECLARE EXIT HANDLER FOR SQLSTATE '23000' SELECT 'Error de código en el servidor' Mensaje, -1 codigo;
    
    
    IF tipo_consulta = 'listado'
	THEN
		SET statment =  
			'SELECT 
					id,
					nom_categoria,
					DATE_FORMAT(fecha_creacion,''%d/%m/%Y'') as fecha_creacion
			FROM pclink.categorias
			WHERE st_categoria = ''A'' ';
		SET statment = CONCAT(statment, filtros);
		SET statment = CONCAT(statment,' ORDER BY fecha_creacion DESC ');
		SET statment = CONCAT(statment,' LIMIT ', init_value,',', limit_value);
		SET @statment := statment;
		PREPARE stmt FROM @statment;
		EXECUTE stmt;
		SELECT COUNT(*) AS total_rows FROM pclink.categorias where st_categoria = 'A';
        deallocate PREPARE stmt;
	end if;
    IF tipo_consulta = 'registrar'
    THEN
		IF NOT EXISTS(SELECT * FROM CATEGORIAS WHERE NOM_CATEGORIA = dato1 AND ST_CATEGORIA = 'A')
        THEN
			INSERT INTO PCLINK.CATEGORIAS(NOM_CATEGORIA, DESCRIPCION,ST_CATEGORIA,fecha_creacion)
									values(dato1,dato2, 'A', current_timestamp());
			SELECT 200 codigo, 'Categoria Registrada con exito' mensaje;
        ELSE
			SELECT -1 codigo, 'La categoria ya existe en la base de datos' mensaje;
        END IF;
    END IF;
    IF tipo_consulta = 'editar'
    THEN
		IF EXISTS(SELECT * FROM CATEGORIAS WHERE ID = filtros AND ST_CATEGORIA = 'A')
        THEN
			IF(dato1 = dato2)
            THEN
				UPDATE CATEGORIAS
					SET
                        DESCRIPCION = dato3
				WHERE ID = filtros AND ST_CATEGORIA = 'A';
                SELECT 200 codigo, 'Actualizacion exitosa' mensaje;
            ELSE
				IF NOT EXISTS( SELECT * FROM CATEGORIAS WHERE NOM_CATEGORIA = dato2 AND  ST_CATEGORIA = 'A')
				THEN
					UPDATE CATEGORIAS
					SET
						NOM_CATEGORIA = dato2,
                        DESCRIPCION = dato3
					WHERE ID = filtros AND ST_CATEGORIA = 'A';
                    SELECT 200 codigo, 'Actualizacion exitosa' mensaje;
				ELSE
					SELECT -1 codigo, 'La categoria ya existe' mensaje;
                END IF;
            END IF;
			ELSE
				SELECT -1 codigo, 'La categoria no existe' mensaje;
        END IF;
    END IF;
	
    IF tipo_consulta = 'eliminar'
    then
		IF EXISTS(SELECT * FROM pclink.CATEGORIAS WHERE ID = FILTROS AND ST_CATEGORIA = 'A')
        THEN
			UPDATE pclink.CATEGORIAS
            SET ST_CATEGORIA = 'X'
            WHERE ID = FILTROS AND ST_CATEGORIA = 'A';
			SELECT 200 codigo, 'La categoria se elimino exitosamente' mensaje;
        ELSE
			SELECT -1 codigo, 'La categoria a eliminar no existe' mensaje;
        END IF;
    end if;
    
    
    IF tipo_consulta = 'consulta'
    then
		IF EXISTS(SELECT * FROM pclink.CATEGORIAS WHERE ID = FILTROS AND ST_CATEGORIA = 'A')
        THEN
			SELECT 
				200 codigo,
                'Mensaje' mensaje,
				ID,
				NOM_CATEGORIA,
				DESCRIPCION
            FROM pclink.CATEGORIAS WHERE ID = FILTROS AND ST_CATEGORIA = 'A' LIMIT 1;
        ELSE
			SELECT -1 codigo, 'La categoria no existe' mensaje;
        END IF;
    end if;
END$$

DROP PROCEDURE IF EXISTS `sp_mensajes`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_mensajes` (IN `tipo_consulta` LONGTEXT, IN `init_value` INT, IN `limit_value` INT, IN `filtros` LONGTEXT, IN `id_usuario` LONGTEXT, IN `dato1` LONGTEXT, IN `dato2` LONGTEXT, IN `dato3` LONGTEXT, IN `dato4` LONGTEXT, IN `dato5` LONGTEXT, IN `dato6` LONGTEXT, IN `dato7` LONGTEXT, IN `dato8` LONGTEXT)  BEGIN
	DECLARE statment VARCHAR(25555);
	-- MANEJO DE EXCEPCIONES
	DECLARE EXIT HANDLER FOR 1062 SELECT 'El registro ya se encuentra repetio' Mensaje, -1 codigo; 
    DECLARE EXIT HANDLER FOR 1054 SELECT 'Error al mencionar el campo de una tabla' Mensaje, -1 codigo; 
    DECLARE EXIT HANDLER FOR SQLEXCEPTION SELECT 'Ocurrio un error en el servidor' Mensaje, -1 codigo;
    DECLARE EXIT HANDLER FOR SQLSTATE '23000' SELECT 'Error de código en el servidor' Mensaje, -1 codigo;
    
    IF tipo_consulta = 'listado'
	THEN
		SET statment =  
			'SELECT 
					id,
					asunto,
					nombre,
                    correo,
                    mensaje,
					DATE_FORMAT(fecha_creacion,''%d/%m/%Y'') as fecha_creacion
			FROM pclink.mensajes
			WHERE st_mensaje != ''X'' ';
		SET statment = CONCAT(statment, filtros);
		SET statment = CONCAT(statment,' ORDER BY fecha_creacion DESC ');
		SET statment = CONCAT(statment,' LIMIT ', init_value,',', limit_value);
		SET @statment := statment;
		PREPARE stmt FROM @statment;
		EXECUTE stmt;
		SELECT COUNT(*) AS total_rows FROM pclink.mensajes where st_mensaje != 'X';
        deallocate PREPARE stmt;
	end if;
    
    
    if tipo_consulta = 'registrar'
    THEN
		INSERT INTO PCLINK.MENSAJES(NOMBRE, CORREO,ASUNTO,MENSAJE,ST_MENSAJE,FECHA_CREACION)
        VALUES(dato1,dato2,dato3,dato4, 'A', current_timestamp());
        SELECT 200 codigo, 'Se ha enviado tu mensaje correctamente' mensaje;
    END IF;
    
    
    if tipo_consulta = 'eliminar'
    THEN
		UPDATE PCLINK.MENSAJES SET ST_MENSAJE = 'X' WHERE ID = filtros;
        
        SELECT 200 codigo, 'Se ha eliminado el mensaje correctamente' mensaje;
    END IF;
    
END$$

DROP PROCEDURE IF EXISTS `sp_pedidos`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_pedidos` (IN `tipo_consulta` LONGTEXT, IN `init_value` INT, IN `limit_value` INT, IN `filtros` LONGTEXT, IN `id_usuario` LONGTEXT, IN `dato1` LONGTEXT, IN `dato2` LONGTEXT, IN `dato3` LONGTEXT, IN `dato4` LONGTEXT, IN `dato5` LONGTEXT, IN `dato6` LONGTEXT, IN `dato7` LONGTEXT, IN `dato8` LONGTEXT)  BEGIN
    DECLARE statment VARCHAR(25555);
    DECLARE CODIGO INT;
    DECLARE valor_final float;
    DECLARE id_tmp int;
    DECLARE cod_producto_carrito int;
    DECLARE cantidad_tmp int;
	DECLARE var_final INTEGER DEFAULT 0;
    DECLARE cursor1 CURSOR FOR SELECT cod_producto,cantidad FROM tmp_carrito where cod_usuario = id_usuario and st_item = 'A';
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET var_final = 1;
	-- MANEJO DE EXCEPCIONES
	DECLARE EXIT HANDLER FOR 1062 SELECT 'El registro ya se encuentra repetio' Mensaje, -1 codigo; 
    DECLARE EXIT HANDLER FOR 1054 SELECT 'Error al mencionar el campo de una tabla' Mensaje, -1 codigo; 
    DECLARE EXIT HANDLER FOR SQLEXCEPTION SELECT 'Ocurrio un error en el servidor' Mensaje, -1 codigo;
    DECLARE EXIT HANDLER FOR SQLSTATE '23000' SELECT 'Error de código en el servidor' Mensaje, -1 codigo;

	IF tipo_consulta = 'listado'
	THEN
		SET statment =  
			'SELECT 
					id,
					valor,
					nombre,
                    CASE
						WHEN st_pedido = ''P'' THEN ''PENDIENTE''
						WHEN st_pedido = ''W'' THEN ''PREPARACION''
                        WHEN st_pedido = ''L'' THEN ''LISTO''
						WHEN st_pedido = ''E'' THEN ''ENVIADO''
                        WHEN st_pedido = ''R'' THEN ''RECIBIDO''
					END estado,
                    CASE
						WHEN st_pedido = ''P'' THEN ''warning''
						WHEN st_pedido = ''W'' THEN ''danger''
                        WHEN st_pedido = ''L'' THEN ''info''
						WHEN st_pedido = ''E'' THEN ''primary''
                        WHEN st_pedido = ''R'' THEN ''success''
					END color_estado,
                    correo,
					DATE_FORMAT(fecha_creacion,''%d/%m/%Y'') as fecha_creacion
			FROM pclink.pedidos
			WHERE st_pedido != ''X'' ';
		SET statment = CONCAT(statment, ' AND cod_usuario = ', id_usuario, ' ');
		SET statment = CONCAT(statment, filtros);
		SET statment = CONCAT(statment,' ORDER BY fecha_creacion DESC ');
		SET statment = CONCAT(statment,' LIMIT ', init_value,',', limit_value);
		SET @statment := statment;
		PREPARE stmt FROM @statment;
		EXECUTE stmt;
		SELECT COUNT(*) AS total_rows FROM pclink.pedidos where st_pedido != 'X' and cod_usuario = id_usuario;
        deallocate PREPARE stmt;
	end if;
    
    IF tipo_consulta = 'listado_gestion'
	THEN
		SET statment =  
			'SELECT 
					id,
					valor,
					nombre,
                    CASE
						WHEN st_pedido = ''P'' THEN ''PENDIENTE''
						WHEN st_pedido = ''W'' THEN ''PREPARACION''
                        WHEN st_pedido = ''L'' THEN ''LISTO''
						WHEN st_pedido = ''E'' THEN ''ENVIADO''
                        WHEN st_pedido = ''R'' THEN ''RECIBIDO''
					END estado,
                    CASE
						WHEN st_pedido = ''P'' THEN ''warning''
						WHEN st_pedido = ''W'' THEN ''danger''
                        WHEN st_pedido = ''L'' THEN ''info''
						WHEN st_pedido = ''E'' THEN ''primary''
                        WHEN st_pedido = ''R'' THEN ''success''
					END color_estado,
                    correo,
					DATE_FORMAT(fecha_creacion,''%d/%m/%Y'') as fecha_creacion
			FROM pclink.pedidos
			WHERE st_pedido != ''X'' ';
		SET statment = CONCAT(statment, filtros);
		SET statment = CONCAT(statment,' ORDER BY fecha_creacion DESC ');
		SET statment = CONCAT(statment,' LIMIT ', init_value,',', limit_value);
		SET @statment := statment;
		PREPARE stmt FROM @statment;
		EXECUTE stmt;
		SELECT COUNT(*) AS total_rows FROM pclink.pedidos where st_pedido != 'X';
        deallocate PREPARE stmt;
	end if;
    
	if tipo_consulta = 'insertar'
    THEN
		SET valor_final := (SELECT sum(A.cantidad * P.precio) total 
							FROM PCLINK.TMP_CARRITO A
							INNER JOIN PCLINK.PRODUCTOS P ON P.ID = A.COD_PRODUCTO
							WHERE a.COD_USUARIO = id_usuario and a.st_item = 'A');
		INSERT INTO pedidos(cod_usuario, valor, pais,provincia, 
				ciudad, nombre, direccion, correo, telefono, st_pedido,fecha_creacion)
		VALUES(id_usuario, valor_final, 'Ecuador', dato1, dato2,dato3,dato4,dato5,dato6,'p', current_timestamp());
        SET CODIGO := (SELECT @@IDENTITY);
		OPEN cursor1;
		bucle: LOOP
		FETCH cursor1 INTO cod_producto_carrito, cantidad_tmp;
			IF var_final = 1 THEN
			  LEAVE bucle;
			END IF;
			INSERT INTO pedido_detalle(cod_pedido,cod_producto, cantidad, cod_usuario, st_item, fecha_creacion)
			VALUES (CODIGO,cod_producto_carrito,cantidad_tmp,id_usuario,'A',CURRENT_TIMESTAMP());
		  END LOOP bucle;
		  CLOSE cursor1;
		DELETE FROM tmp_carrito WHERE COD_USUARIO = id_usuario and st_item = 'A';
        select 200 codigo, CODIGO as id;
    END IF;
    
    
    if tipo_consulta = 'detalle'
    THEN
		SELECT 
			ID,
            VALOR,
            NOMBRE,
            CIUDAD,
            PROVINCIA,
            DIRECCION,
            CORREO,
            TELEFONO,
            ST_PEDIDO,
			DATE_FORMAT(fecha_creacion,'%d/%m/%Y') as fecha_creacion 
		FROM PEDIDOS WHERE ID = filtros;
        
        SELECT 
			a.cod_producto, p.imagen_producto,p.nom_producto, p.precio,a.cantidad
        FROM PEDIDO_DETALLE a
        INNER JOIN PRODUCTOS p ON a.cod_producto = p.id
        WHERE a.st_item = 'A'
        AND a.COD_PEDIDO = filtros;
    END IF;
    
    IF tipo_consulta = 'actualizar_cliente'
    THEN
		UPDATE PCLINK.PEDIDOS SET ST_PEDIDO = 'R' WHERE ID = filtros AND ST_PEDIDO = 'E';
        SELECT 200 codigo, 'Pedido Actualizado Correctamente' mensaje;
    END IF;
    
    IF tipo_consulta = 'actualizar_gestion'
    THEN
		UPDATE PCLINK.PEDIDOS SET ST_PEDIDO = dato1 WHERE ID = filtros;
        SELECT 200 codigo , 'Pedido Actualizado Correctamente' mensaje;
    END IF;
END$$

DROP PROCEDURE IF EXISTS `sp_productos`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_productos` (IN `tipo_consulta` LONGTEXT, IN `init_value` INT, IN `limit_value` INT, IN `filtros` LONGTEXT, IN `dato1` LONGTEXT, IN `dato2` LONGTEXT, IN `dato3` LONGTEXT, IN `dato4` LONGTEXT, IN `dato5` LONGTEXT, IN `dato6` LONGTEXT, IN `dato7` LONGTEXT, IN `dato8` LONGTEXT)  BEGIN
	DECLARE statment VARCHAR(25555);
    DECLARE CODIGO INT;
	-- MANEJO DE EXCEPCIONES
	DECLARE EXIT HANDLER FOR 1062 SELECT 'El registro ya se encuentra repetio' Mensaje, -1 codigo; 
    DECLARE EXIT HANDLER FOR 1054 SELECT 'Error al mencionar el campo de una tabla' Mensaje, -1 codigo; 
    DECLARE EXIT HANDLER FOR SQLEXCEPTION SELECT 'Ocurrio un error en el servidor' Mensaje, -1 codigo;
    DECLARE EXIT HANDLER FOR SQLSTATE '23000' SELECT 'Error de código en el servidor' Mensaje, -1 codigo;
    
    
    IF tipo_consulta = 'listado'
	THEN
		SET statment =  
			'SELECT 
				a.ID,
				a.COD_CATEGORIA,
				c.NOM_CATEGORIA,
				a.NOM_PRODUCTO,
                a.DESCRIPCION,
                a.PRECIO,
				a.IMAGEN_PRODUCTO
			FROM productos a
			INNER JOIN categorias c ON c.id = a.cod_categoria
            WHERE a.ST_PRODUCTO = ''A'' ';
		SET statment = CONCAT(statment, filtros);
		SET statment = CONCAT(statment,' ORDER BY a.fecha_creacion DESC ');
		SET statment = CONCAT(statment,' LIMIT ', init_value,',', limit_value);
		SET @statment := statment;
		PREPARE stmt FROM @statment;
		EXECUTE stmt;
		SELECT COUNT(*) AS total_rows FROM pclink.productos where st_producto = 'A';
        deallocate PREPARE stmt;
	end if;
    
    
    IF tipo_consulta = 'registrar'
    THEN
		IF NOT EXISTS(SELECT * FROM PRODUCTOS WHERE NOM_PRODUCTO = dato1 AND ST_PRODUCTO = 'A')
        THEN
			INSERT INTO PCLINK.PRODUCTOS(NOM_PRODUCTO,COD_CATEGORIA,DESCRIPCION,PRECIO,STOCK,ST_PRODUCTO,fecha_creacion)
									values(dato1,dato2,dato3,dato4,dato5,'A',current_timestamp());
			SET CODIGO := (SELECT @@IDENTITY);
            IF(dato6 = 'SI')
            THEN
				UPDATE PRODUCTOS SET IMAGEN_PRODUCTO = CONCAT(CODIGO,'.jpg') WHERE ID = CODIGO AND ST_PRODUCTO = 'A';
            END IF;
			SELECT CODIGO as codigo, 'Producto registrado con exito' mensaje;
        ELSE
			SELECT -1 codigo, 'El producto ya existe en la base de datos' mensaje;
        END IF;
    END IF;
    IF tipo_consulta = 'editar'
    THEN
		IF EXISTS(SELECT * FROM PRODUCTOS WHERE ID = filtros AND ST_PRODUCTO = 'A')
        THEN
			IF(dato1 = dato2)
            THEN
				UPDATE PRODUCTOS
					SET
                        DESCRIPCION = dato3,
                        COD_CATEGORIA = dato4,
                        PRECIO = dato5,
                        STOCK = dato6
				WHERE ID = filtros AND ST_PRODUCTO = 'A';
                
                IF(dato7  = 'SI')
                THEN
					UPDATE PRODUCTOS SET IMAGEN_PRODUCTO = CONCAT(filtros,'.jpg') WHERE ID = filtros AND ST_PRODUCTO = 'A';
                END IF;
                SELECT 200 codigo, 'Actualizacion exitosa' mensaje;
            ELSE
				IF NOT EXISTS( SELECT * FROM PRODUCTOS WHERE NOM_PRODUCTO = dato2 AND  ST_PRODUCTO = 'A')
				THEN
					UPDATE PRODUCTOS
					SET
						NOM_PRODUCTO = dato2,
                        DESCRIPCION = dato3,
                        COD_CATEGORIA = dato4,
                        PRECIO = dato5,
                        STOCK = dato6
					WHERE ID = filtros AND ST_PRODUCTO = 'A';
                    
                    IF(dato7  = 'SI')
					THEN
						UPDATE PRODUCTOS SET IMAGEN_PRODUCTO = CONCAT(filtros,'.jpg') WHERE ID = filtros AND ST_PRODUCTO = 'A';
					END IF;
                    SELECT 200 codigo, 'Actualizacion exitosa' mensaje;
				ELSE
					SELECT -1 codigo, 'El producto ya existe' mensaje;
                END IF;
            END IF;
			ELSE
				SELECT -1 codigo, 'El producto no existe' mensaje;
        END IF;
    END IF;
	
    IF tipo_consulta = 'eliminar'
    then
		IF EXISTS(SELECT * FROM pclink.PRODUCTOS WHERE ID = FILTROS AND ST_PRODUCTO = 'A')
        THEN
			UPDATE pclink.PRODUCTOS
            SET ST_PRODUCTO = 'X'
            WHERE ID = FILTROS AND ST_PRODUCTO = 'A';
			SELECT 200 codigo, 'El producto se elimino exitosamente' mensaje;
        ELSE
			SELECT -1 codigo, 'El producto a eliminar no existe' mensaje;
        END IF;
    end if;
    IF tipo_consulta = 'getCategorias'
    THEN
		SELECT ID, NOM_CATEGORIA FROM CATEGORIAS WHERE ST_CATEGORIA = 'A';
    END IF;
    
    IF tipo_consulta = 'consulta'
    then
		IF EXISTS(SELECT * FROM pclink.PRODUCTOS WHERE ID = FILTROS AND ST_PRODUCTO = 'A')
        THEN
			SELECT 
				200 codigo,
                'Mensaje' mensaje,
				ID,
                NOM_PRODUCTO,
				COD_CATEGORIA,
				DESCRIPCION,
                IMAGEN_PRODUCTO,
                PRECIO,
                STOCK
            FROM pclink.PRODUCTOS WHERE ID = FILTROS AND ST_PRODUCTO = 'A' LIMIT 1;
        ELSE
			SELECT -1 codigo, 'El producto no existe' mensaje;
        END IF;
    end if;
END$$

DROP PROCEDURE IF EXISTS `sp_usuarios`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_usuarios` (IN `tipo_consulta` LONGTEXT, IN `init_value` INT, IN `limit_value` INT, IN `filtros` LONGTEXT, IN `cod_usuario` INT, IN `dato1` LONGTEXT, IN `dato2` LONGTEXT, IN `dato3` LONGTEXT, IN `dato4` LONGTEXT, IN `dato5` LONGTEXT, IN `dato6` LONGTEXT)  BEGIN
	DECLARE statment VARCHAR(25555);
	-- MANEJO DE EXCEPCIONES
	DECLARE EXIT HANDLER FOR 1062 SELECT 'El registro ya se encuentra repetio' Mensaje, -1 codigo; 
    DECLARE EXIT HANDLER FOR 1054 SELECT 'Error al mencionar el campo de una tabla' Mensaje, -1 codigo; 
    DECLARE EXIT HANDLER FOR SQLEXCEPTION SELECT 'Ocurrio un error en el servidor' Mensaje, -1 codigo;
    DECLARE EXIT HANDLER FOR SQLSTATE '23000' SELECT 'Error de código en el servidor' Mensaje, -1 codigo;
    
    
    IF tipo_consulta = 'listado'
	THEN
		SET statment =  
			'SELECT 
					id,
					nombre_usuario,email,
					DATE_FORMAT(fecha_creacion,''%d/%m/%Y'') as fecha_creacion,
					rol
			FROM pclink.usuarios
			WHERE st_usuario = ''A'' ';
		SET statment = CONCAT(statment, filtros);
		SET statment = CONCAT(statment,' ORDER BY fecha_creacion DESC ');
		SET statment = CONCAT(statment,' LIMIT ', init_value,',', limit_value);
		SET @statment := statment;
		PREPARE stmt FROM @statment;
		EXECUTE stmt;
		SELECT COUNT(*) AS total_rows FROM pclink.usuarios where st_usuario = 'A';
        deallocate PREPARE stmt;
	end if;
    IF tipo_consulta = 'iniciar_sesion'
	THEN
		IF EXISTS(SELECT * FROM USUARIOS WHERE NOMBRE_USUARIO = dato1 AND PASSWORD = dato2 AND ST_USUARIO = 'A')
        THEN	
			SELECT 200 codigo,'Exito' mensaje, ID, NOMBRE_USUARIO, NOMBRES, EMAIL, ROL
            FROM USUARIOS
            WHERE NOMBRE_USUARIO = dato1
            AND PASSWORD = dato2
            AND ST_USUARIO = 'A'
            limit 1;
        ELSE
			SELECT -1 codigo, 'El usuario no se encuentra en la base de datos' mensaje;
        END IF;
    END IF;
    IF tipo_consulta = 'registrar'
    THEN
		IF NOT EXISTS(SELECT * FROM USUARIOS WHERE NOMBRE_USUARIO = dato1 AND ST_USUARIO = 'A')
        THEN
			INSERT INTO PCLINK.USUARIOS(nombre_usuario, password,nombres,
										email,telefono,rol,st_usuario,fecha_creacion)
									values(dato1,dato2,dato3,dato4,dato5,dato6, 'A', current_timestamp());
			SELECT 200 codigo, 'Usuario Registrado con exito' mensaje;
        ELSE
			SELECT -1 codigo, 'El usuario ya existe en la base de datos' mensaje;
        END IF;
    END IF;
    IF tipo_consulta = 'editar'
    THEN
		IF EXISTS(SELECT * FROM USUARIOS WHERE ID = FILTROS AND ST_USUARIO = 'A')
        THEN
			IF(dato1 = dato2)
            THEN
				UPDATE USUARIOS
					SET
						NOMBRES = dato3,
                        EMAIL = dato4,
                        TELEFONO = dato5,
                        PASSWORD = dato6
				WHERE ID = FILTROS AND ST_USUARIO = 'A';
                SELECT 200 codigo, 'Actualizacion exitosa' mensaje;
            ELSE
				IF NOT EXISTS( SELECT * FROM USUARIOS WHERE NOMBRE_USUARIO = dato2 AND  ST_USUARIO = 'A')
				THEN
					UPDATE USUARIOS
						SET
							NOMBRE_USUARIO = dato2,
							NOMBRES = dato3,
							EMAIL = dato4,
							TELEFONO = dato5,
							PASSWORD = dato6
					WHERE ID = FILTROS AND ST_USUARIO = 'A';
                    
                    SELECT 200 codigo, 'Actualizacion exitosa' mensaje;
				ELSE
					SELECT -1 codigo, 'El nombre de usuario ya esta ocupado' mensaje;
                END IF;
            END IF;
		END IF;
    END IF;
	
    IF tipo_consulta = 'eliminar'
    then
		IF EXISTS(SELECT * FROM pclink.USUARIOS WHERE ID = FILTROS AND ST_USUARIO = 'A')
        THEN
			UPDATE pclink.USUARIOS
            SET ST_USUARIO = 'X'
            WHERE ID = FILTROS AND ST_USUARIO = 'A';
			SELECT 200 codigo, 'El usuario se elimino exitosamente' mensaje;
        ELSE
			SELECT -1 codigo, 'El usuario a eliminar no existe' mensaje;
        END IF;
    end if;
    
    
    IF tipo_consulta = 'consulta'
    then
		IF EXISTS(SELECT * FROM pclink.USUARIOS WHERE ID = FILTROS AND ST_USUARIO = 'A')
        THEN
			SELECT 
				200 codigo,
                'Mensaje' mensaje,
				ID,
                PASSWORD,
				NOMBRE_USUARIO,
				EMAIL,
				TELEFONO,
				NOMBRES
            FROM pclink.USUARIOS WHERE ID = FILTROS AND ST_USUARIO = 'A' LIMIT 1;
        ELSE
			SELECT -1 codigo, 'El usuario no existe' mensaje;
        END IF;
    end if;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nom_categoria` longtext NOT NULL,
  `descripcion` longtext NOT NULL,
  `st_categoria` char(1) NOT NULL DEFAULT '',
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabla para categorias';

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nom_categoria`, `descripcion`, `st_categoria`, `fecha_creacion`) VALUES
(1, 'Tecnologia', '<p>asdasdasd</p>\r\n', 'X', '2022-02-13 23:46:41'),
(2, 'Ropa', '<p>xasxasxs</p>\r\n', 'X', '2022-02-13 23:46:46'),
(3, 'Categoria1', '<p>asdasdasd</p>\r\n', 'X', '2022-02-13 23:56:40'),
(4, 'Servicios', '<p>Todos los servicios disponibles de la empresa</p>\r\n', 'X', '2022-02-14 20:04:45'),
(6, 'Tecnologia', '<p>Productos tecnologicos</p>\r\n', 'A', '2022-02-14 23:52:16'),
(7, 'Electronica2', '<p>Productos selectronicos</p>\r\n', 'A', '2022-02-19 21:36:08'),
(8, 'asdas', '<p>asdasd</p>\r\n', 'X', '2022-02-23 17:57:43'),
(9, 'afg', '<p>asdfg</p>\r\n', 'X', '2022-02-23 18:11:49'),
(10, 'Categoria nueva', '<p>Descripcion</p>\r\n', 'A', '2022-02-26 11:53:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

DROP TABLE IF EXISTS `mensajes`;
CREATE TABLE `mensajes` (
  `id` int(11) NOT NULL,
  `nombre` longtext DEFAULT NULL,
  `correo` longtext DEFAULT NULL,
  `asunto` longtext DEFAULT NULL,
  `mensaje` longtext DEFAULT NULL,
  `st_mensaje` char(1) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `mensajes`
--

INSERT INTO `mensajes` (`id`, `nombre`, `correo`, `asunto`, `mensaje`, `st_mensaje`, `fecha_creacion`) VALUES
(1, 'Cristhian Baidal', 'crhighlander94@gmail.com', 'asdasdasd', 'asdasdas', 'X', '2022-02-20 17:13:08'),
(2, 'Cristhian Baidal', 'crhighlander94@gmail.com', 'asdasdasd', 'asdfgjklñ', 'X', '2022-02-20 17:15:28'),
(3, 'Cristhian Baidal', 'crhighlander94@gmail.com', 'asdasdasd', 'asdfgjklñ', 'X', '2022-02-20 17:15:59'),
(4, 'Cristhian Baidal', 'crhighlander94@gmail.com', 'asdasdasd', 'asdfgjklñ', 'X', '2022-02-20 17:16:23'),
(5, 'Cristhian Baidal', 'crhighlander94@gmail.com', 'asdasdasd', 'asdasdasd', 'X', '2022-02-20 17:17:46'),
(6, 'Cristhian Baidal', 'crhighlander94@gmail.com', 'asdasdasd', 'asdasdasdasd', 'X', '2022-02-20 17:22:40'),
(7, 'Cristhian Baidal', 'crhighlander94@gmail.com', 'asdasdasd', 'asdasd', 'X', '2022-02-20 17:37:52'),
(8, 'Persona Prueba', 'crhighlander94@gmail.com', 'Contactarme', 'Me gustaria poder hacer negocios con ustedes.', 'X', '2022-02-20 23:13:22'),
(9, 'Cristhian Baidal', 'crhighlander94@gmail.com', 'Contactarme222', 'asdasdasd', 'X', '2022-02-20 23:13:47'),
(10, 'Cristhian2', 'rabil15@hotmail.com', 'asdasd', 'sadasdasdsa', 'X', '2022-02-20 23:24:34'),
(11, 'Cristhian Baidal', 'ronalddavidchica@gmail.com', 'asdasd', 'fasdasd', 'A', '2022-02-20 23:31:41'),
(12, 'Cristhian3', 'asalazar@agripac.com.ec', 'Contactarme222', 'asdadsasd', 'A', '2022-02-26 11:51:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `cod_usuario` int(11) NOT NULL,
  `valor` mediumtext NOT NULL,
  `pais` mediumtext NOT NULL,
  `provincia` mediumtext NOT NULL,
  `ciudad` mediumtext NOT NULL,
  `nombre` longtext NOT NULL,
  `direccion` mediumtext NOT NULL,
  `correo` longtext NOT NULL,
  `telefono` mediumtext NOT NULL,
  `st_pedido` char(1) NOT NULL DEFAULT 'A',
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `cod_usuario`, `valor`, `pais`, `provincia`, `ciudad`, `nombre`, `direccion`, `correo`, `telefono`, `st_pedido`, `fecha_creacion`) VALUES
(1, 3, '500', 'Ecuador', 'Guayas', 'GUAYAQUIL', 'Cristhian Baidal', 'Av. Francisco de Orellana, Guayaquil, Ecuador', 'crhighlander94@gmail.com', '+593984860257', 'R', '2022-02-20 13:29:42'),
(2, 3, '1531.9', 'Ecuador', 'Guayas', 'GUAYAQUIL', 'Persona Prueba', 'oficina 305', 'rabil15@hotmail.com', '+593984860257', 'R', '2022-02-20 13:33:46'),
(3, 3, '49325.9', 'Ecuador', 'Guayas', 'GUAYAQUIL', 'Cristhian Baidal', 'San Marino Shopping, Avenida Francisco de Orellana, Guayaquil, Ecuador', 'crhighlander94@gmail.com', '+593984860257', 'R', '2022-02-20 15:34:20'),
(4, 3, '1596.8', 'Ecuador', 'Guayas', 'GUAYAQUIL', 'Cristhian Baidal', 'Av. Francisco de Orellana, Guayaquil, Ecuador', 'crhighlander94@gmail.com', '+593984860257', 'E', '2022-02-20 17:26:27'),
(5, 3, '93', 'Ecuador', 'Guayas', 'GUAYAQUIL', 'Cristhian Baidal', 'Av. Francisco de Orellana, Guayaquil, Ecuador', 'test@mail.com', '+593984860257', 'p', '2022-02-26 12:17:19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_detalle`
--

DROP TABLE IF EXISTS `pedido_detalle`;
CREATE TABLE `pedido_detalle` (
  `id` int(11) NOT NULL,
  `cod_pedido` int(11) NOT NULL,
  `cod_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `cod_usuario` int(11) NOT NULL,
  `st_item` char(1) NOT NULL DEFAULT 'A',
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pedido_detalle`
--

INSERT INTO `pedido_detalle` (`id`, `cod_pedido`, `cod_producto`, `cantidad`, `cod_usuario`, `st_item`, `fecha_creacion`) VALUES
(1, 1, 8, 1, 3, 'A', '2022-02-20 13:29:42'),
(2, 2, 7, 1, 3, 'A', '2022-02-20 13:33:46'),
(3, 2, 8, 3, 3, 'A', '2022-02-20 13:33:46'),
(4, 2, 5, 3, 3, 'A', '2022-02-20 13:33:46'),
(5, 3, 6, 1, 3, 'A', '2022-02-20 15:34:20'),
(6, 3, 5, 3, 3, 'A', '2022-02-20 15:34:20'),
(7, 3, 1, 4, 3, 'A', '2022-02-20 15:34:20'),
(8, 4, 6, 5, 3, 'A', '2022-02-20 17:26:27'),
(9, 4, 5, 1, 3, 'A', '2022-02-20 17:26:27'),
(10, 4, 8, 3, 3, 'A', '2022-02-20 17:26:27'),
(11, 4, 7, 1, 3, 'A', '2022-02-20 17:26:27'),
(12, 4, 4, 1, 3, 'A', '2022-02-20 17:26:27'),
(13, 5, 10, 1, 3, 'A', '2022-02-26 12:17:20'),
(14, 5, 9, 4, 3, 'A', '2022-02-26 12:17:20'),
(15, 5, 3, 1, 3, 'A', '2022-02-26 12:17:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `cod_categoria` int(11) DEFAULT NULL,
  `nom_producto` longtext DEFAULT NULL,
  `imagen_producto` longtext DEFAULT NULL,
  `descripcion` longtext DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `precio` float DEFAULT NULL,
  `st_producto` char(1) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabla de productos';

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `cod_categoria`, `nom_producto`, `imagen_producto`, `descripcion`, `stock`, `precio`, `st_producto`, `fecha_creacion`) VALUES
(1, 4, 'Sucursal1', '1.jpg', '<p>asdasd</p>\r\n', 0, 12321, 'X', '2022-02-14 22:35:18'),
(2, 4, 'Playa', '2.jpg', '<p>Un viajecito relajado</p>\r\n', 0, 50.5, 'X', '2022-02-14 23:07:22'),
(3, 4, 'Nuevo producto', '3.jpg', '<p>Tomatela111</p>\r\n', 0, 15.5, 'A', '2022-02-14 23:36:10'),
(4, 4, 'Bueno', '4.jpg', '<p>asdasdas</p>\r\n', 0, 5, 'A', '2022-02-14 23:36:26'),
(5, 4, 'Creando uno nuevo1', '5.jpg', '<p>asdasdassss</p>\r\n', 0, 8.8, 'X', '2022-02-14 23:36:41'),
(6, 6, 'Elegante', '6.jpg', '<p>asdasdsa</p>\r\n', 0, 15.5, 'A', '2022-02-14 23:53:12'),
(7, 10, 'Parlantes', '7.jpg', '<p>Parlantes marca 500</p>\r\n', 0, 5.5, 'A', '2022-02-19 21:34:21'),
(8, 6, 'Latop', '8.jpg', '<p>Latop HP</p>\r\n', 0, 500, 'X', '2022-02-19 21:35:30'),
(9, 7, 'Ejémplo de categoria3', '9.jpg', '<p>Esta es una descripcion</p>\r\n', 0, 15.5, 'A', '2022-02-20 17:31:03'),
(10, 7, 'Figura de accion', '10.jpg', '<p>Descripcion poderosa</p>\r\n', 0, 15.5, 'A', '2022-02-26 11:59:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tmp_carrito`
--

DROP TABLE IF EXISTS `tmp_carrito`;
CREATE TABLE `tmp_carrito` (
  `id` int(11) NOT NULL,
  `cod_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `cod_usuario` int(11) NOT NULL,
  `st_item` char(1) NOT NULL DEFAULT 'A',
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre_usuario` mediumtext NOT NULL,
  `password` longtext NOT NULL,
  `nombres` longtext NOT NULL,
  `email` longtext NOT NULL,
  `telefono` mediumtext NOT NULL,
  `rol` char(1) NOT NULL DEFAULT '',
  `st_usuario` char(1) NOT NULL DEFAULT '',
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Usuarios creados';

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre_usuario`, `password`, `nombres`, `email`, `telefono`, `rol`, `st_usuario`, `fecha_creacion`) VALUES
(1, '@cristhian94', 'MTIzNDU=', 'josesita', 'crhighlander94@gmail.com', '593984860257', 'A', 'A', '2022-02-13 18:30:25'),
(2, '@fernando2', 'QGZlcm5hbmRv', '@fernando', 'crhighlander94@gmail.com', '593912323', 'C', 'X', '2022-02-13 18:46:57'),
(3, '@Cliente1', 'MTIzNDU=', 'Cristhian Baidal', 'rabil15@hotmail.com', '+593984860257', 'C', 'A', '2022-02-13 22:09:07'),
(4, '@anny3', 'MTIzNDU2', 'Ana Mercedes', 'anny@gmail.com', '59595959', 'C', 'A', '2022-02-18 01:59:38'),
(5, '@admin', 'MTIzNDU=', 'Cristhian Baidal', 'crhighlander94@gmail.com', '+593984860257', 'A', 'X', '2022-02-20 15:43:54'),
(6, '@admin2', 'MTIzNDU=', 'Cristhian Baidal', 'crhighlander94@gmail.com', '+593984860257', 'A', 'A', '2022-02-20 18:14:08');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedido_detalle`
--
ALTER TABLE `pedido_detalle`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tmp_carrito`
--
ALTER TABLE `tmp_carrito`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `pedido_detalle`
--
ALTER TABLE `pedido_detalle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `tmp_carrito`
--
ALTER TABLE `tmp_carrito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
