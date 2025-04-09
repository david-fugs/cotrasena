CREATE TABLE `usuarios` (
  `id_usu` int(11) NOT NULL,
  `usuario` varchar(40) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nombre` varchar(80) NOT NULL,
  `tipo_usu` int(11) NOT NULL DEFAULT '3'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usu`);

ALTER TABLE `usuarios`
  MODIFY `id_usu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
