START TRANSACTION;

INSERT INTO perfil (nome)
 VALUES
  ('admin'),
  ('usuario');

INSERT INTO usuario (nome, email, senha, id_perfil)
 VALUES
  ('Rodrigo Ribeiro', 'digocbj@gmail.com', md5('teste'), 1);

COMMIT;