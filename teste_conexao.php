
<?php
require 'db.php';

echo "Conexão bem-sucedida!";
?>


CREATE TABLE tipo_professor (
   cod_tipo_professor TINYINT PRIMARY KEY,
   nm_tipo_professor VARCHAR(25) 
);

CREATE TABLE prof (
    cod_prof INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cod_tipoProfessor TINYINT
    CONSTRAINT fk_prof_tipoprofessor FOREIGN KEY(cod_tipoProfessor)
    REFERENCES tipo_professor
);

