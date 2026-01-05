<?php
/**
 * Registro dos campos ACF para Impacto do Upcycling
 */

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_impacto_upcycling',
	'title' => 'Impacto do Upcycling',
	'fields' => array(
		array(
			'key' => 'field_ingrediente_reaproveitado',
			'label' => 'Ingrediente Reaproveitado',
			'name' => 'ci_ingrediente_reaproveitado',
			'type' => 'text',
			'instructions' => 'Ex: Cascas de batata, Talos de couve, Borra de café', // Consolidado
			'required' => 0,
			'placeholder' => 'O que seria descartado?', // Melhoria UX
		),
		array(
			'key' => 'field_tipo_reaproveitamento',
			'label' => 'Tipo de Reaproveitamento',
			'name' => 'ci_tipo_reaproveitamento',
			'type' => 'select',
			'choices' => array(
				'casca'   => 'Casca',
				'talo'    => 'Talo',
				'semente' => 'Semente',
				'sobra'   => 'Sobra de refeição',
				'outro'   => 'Outro',
			),
			'default_value' => 'casca', // Mantido do arquivo mais completo
			'ui' => 1,
			'ajax' => 0,
		),
		array(
			'key' => 'field_economia_estimada',
			'label' => 'Economia Estimada (R$)',
			'name' => 'ci_economia_estimada',
			'type' => 'number',
			'instructions' => 'Quanto esta receita economiza financeiramente',
			'min' => 0,
			'step' => 0.01, // Precisão decimal para moeda
		),
		array(
			'key' => 'field_lixo_evitado',
			'label' => 'Lixo Evitado (gramas)',
			'name' => 'ci_lixo_evitado',
			'type' => 'number',
			'instructions' => 'Peso aproximado do resíduo orgânico reaproveitado',
			'min' => 0,
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'wprm_recipe', // Vinculado ao WP Recipe Maker
			),
		),
	),
	'style' => 'default',
	'active' => true,
));

endif;