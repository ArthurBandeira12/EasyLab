-- aqruvio para modificar obanco se ja tiver o banco criado
USE easylab;

ALTER TABLE usuario 
ADD COLUMN foto_perfil VARCHAR(255) NULL DEFAULT NULL;
