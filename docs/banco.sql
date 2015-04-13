--Postgres
CREATE TABLE public.perfil
(
   id serial NOT NULL, 
   nome character varying(100) NOT NULL, 
   CONSTRAINT pk_perfil PRIMARY KEY (id)
) 
WITH (
  OIDS = FALSE
)
;
CREATE TABLE public.usuario
(
   id serial NOT NULL, 
   nome character varying(100) NOT NULL, 
   email character varying(100) NOT NULL, 
   senha character varying(40) NOT NULL, 
   id_perfil integer NOT NULL, 
   CONSTRAINT pk_usuario PRIMARY KEY (id), 
   CONSTRAINT fk_pessoa_perfil FOREIGN KEY (id_perfil) REFERENCES perfil (id) ON UPDATE NO ACTION ON DELETE NO ACTION
) 
WITH (
  OIDS = FALSE
)
;
CREATE TABLE public.post
(
   id serial NOT NULL, 
   titulo character varying(200) NOT NULL, 
   titulo_limpo character varying(200) NOT NULL, 
   url_post character varying(200) NOT NULL, 
   conteudo text NOT NULL, 
   data timestamp with time zone NOT NULL DEFAULT now(), 
   id_usuario integer NOT NULL, 
   CONSTRAINT pk_post PRIMARY KEY (id), 
   CONSTRAINT fk_post_usuario FOREIGN KEY (id_usuario) REFERENCES usuario (id) ON UPDATE NO ACTION ON DELETE NO ACTION
) 
WITH (
  OIDS = FALSE
)
;
--MySQL
CREATE TABLE perfil
(
   id int NOT NULL AUTO_INCREMENT,
   nome varchar(100) NOT NULL,
   PRIMARY KEY (id)
);
CREATE TABLE usuario
(
   id int NOT NULL AUTO_INCREMENT,
   nome varchar(100) NOT NULL,
   email varchar(100) NOT NULL,
   senha varchar(40) NOT NULL,
   id_perfil int NOT NULL,
   PRIMARY KEY (id),
   FOREIGN KEY (id_perfil) REFERENCES perfil (id)
);
CREATE TABLE post
(
   id int NOT NULL AUTO_INCREMENT,
   titulo varchar(200) NOT NULL,
   titulo_limpo varchar(200) NOT NULL,
   url_post varchar(200) NOT NULL,
   conteudo text NOT NULL,
   data TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   id_usuario int NOT NULL,
   PRIMARY KEY (id),
   FOREIGN KEY (id_usuario) REFERENCES usuario (id)
);