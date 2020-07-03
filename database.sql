SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

INSERT INTO `modulos` (`nome`, `url`, `icone`, `status`, `ordem`, `tabela`, `cod_head`, `data_atualizacao`, `chave`)
SELECT 'Enquete', 'enquete.php', 'icon-pencil-square-o', 1, 0, 'enquete', 'enquete/enquete.js', '2020-06-26', '72b4b1d7ce2b514a981a49b1db5790a7';

CREATE TABLE IF NOT EXISTS `enquete` (
  `id` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `pergunta` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `pergunta_outros` varchar(255) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ALTER TABLE `enquete` ADD PRIMARY KEY (`id`);
ALTER TABLE `enquete` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


CREATE TABLE IF NOT EXISTS `c_enquete` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `tipo` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `resultado` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `txt_bt` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `recompensa` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `cor_titulo` varchar(255) CHARACTER SET utf8 COLLATE utf8_estonian_ci DEFAULT NULL,
  `cor_conteudo` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `cor_fundo` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `cor_da_borda` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `cor_txt_bt` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `cor_bg_bt` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `cor_hover_txt_bt` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `cor_hover_bg_bt` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `votos` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `c_enquete` ADD PRIMARY KEY (`id`);
ALTER TABLE `c_enquete` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


CREATE TABLE IF NOT EXISTS `alt_enquete` (
  `id` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_pergunta` int(11) DEFAULT NULL,
  `alternativa` text CHARACTER SET utf8 DEFAULT NULL,
  `zero` int(255) NOT NULL,
  `tag` varchar(255) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `alt_enquete` ADD PRIMARY KEY (`id`);
ALTER TABLE `alt_enquete` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE IF NOT EXISTS `out_enquete` (
  `id` int(255) NOT NULL,
  `id_pergunta` int(255) NOT NULL,
  `resposta` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `out_enquete` ADD PRIMARY KEY (`id`);
ALTER TABLE `out_enquete` MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;


CREATE TABLE IF NOT EXISTS `res_enquete` (
  `id` int(255) NOT NULL,
  `id_categoria` int(255) DEFAULT NULL,
  `id_pergunta` int(255) DEFAULT NULL,
  `resposta` text CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `res_enquete` ADD PRIMARY KEY (`id`);
ALTER TABLE `res_enquete` MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

UPDATE `modulos` SET `acao` = '{\"item\":[\"adicionar\",\"editar\",\"deletar\"],\"categoria\":[\"adicionar\",\"editar\",\"deletar\"],\"codigo\":[\"acessar\"],\"relatorio\":[\"acessar\"]}' WHERE `modulos`.`url` = 'enquete.php';