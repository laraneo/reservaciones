<?php

return [

    /*
    |--------------------------------------------------------------------------
    | App Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used by the front booking to build
    | the multilingual booking. You are free to change them to anything
    | you want to customize your views to better match your application.
    |
    */

	'player' => 'Jugador',
	'player_placeholder' => 'Cédula del Jugador',


	'group_id' => 'Acción',
	'doc_id' => 'Cédula',
    'booking' => 'Reserva',
    'login_link' => 'Iniciar sesión',
    'credit_card' => 'Tarjeta de Crédito',
    'paypal' => 'PayPal',
    'my_account_link' => 'Mi cuenta',
    'logout_link' => 'Cerrar sesión',
    'welcome_title' => 'Hagamos una reserva',
    'welcome_page_title' => 'Inicio',
    'welcome_subtitle' => 'Comience proporcionando su información básica y seleccionando un paquete.',
    'personal_details' => 'Tus detalles personales',
    'first_name' => 'Nombre',
    'last_name' => 'Apellido',
    'phone_number' => 'Número de teléfono',
    'email' => 'Correo electrónico',
    'existing_email_error' => 'Su correo electrónico ya está registrado. Por favor ingresa primero.',
    'first_name_error' => 'Por favor proporciona tu primer nombre.',
    'last_name_error' => 'Por favor ingrese su apellido.',
    'phone_error' => 'Por favor ingrese su número de teléfono.',
    'email_error' => 'Por favor ingrese su correo electrónico.',
    'no_category_error' => 'No se encontró categoría Por favor, vuelva más tarde.',
    'existing_phone_error' => 'El número de teléfono ya está asociado a una cuenta.',
    'booking_type' => 'Tipo de su reserva',
    'booking_type_personal' => 'Personales',
    'booking_type_business' => 'Negocio',
    'booking_category' => 'Seleccione una categoría adecuada',
    'booking_package_title' => 'Seleccione su paquete preferido',
    'booking_package_btn_select' => 'Seleccionar',
    'booking_package_btn_selected' => 'Seleccionado',
    'booking_package_duration_single' => 'Hora',
    'booking_package_duration_multiple' => 'Horas',
    'no_package_error' => 'No se encontraron paquetes para su tipo de reserva. Por favor, vuelva más tarde.',
    'no_package_selected_error' => 'Por favor, seleccione un paquete para continuar.',
	
    'welcome_post_btn' => 'Siguiente',
	/*'welcome_post_btn' => 'Seleccione Fecha y Hora de Reserva',*/
 
    'step_players_page_title' => 'Seleccionar Participantes',
    'step_players_subtitle' => 'Recuerde hay un máximo de invitados por reservación',
	'step_player_button' => 'Siguiente',
	/*'step_player_button' => 'Seleccione servicios adicionales',*/

	'step_two_page_title' => 'Seleccionar Fecha y Hora de reserva',
    'step_two_subtitle' => 'Proporcione su dirección y seleccione el tiempo.',
	'step_two_button' => 'Seleccione participantes',

    'step_three_title' => 'Seleccionar Servicios Adicionales',
    'step_three_subtitle' => 'Agregue cualquier servicio adicional si lo desea.',
    'step_three_button' => 'Finaliza la reserva',

    'final_step_title' => 'Finaliza la reserva',
    'final_step_subtitle' => 'Por favor, revise todas las opciones y finalice su reserva.',
	
    'provide_address' => 'Proporcionar dirección (Opcional)',
    'address_placeholder' => 'Ingrese su dirección',
    'select_date' => 'Seleccionar fecha de reserva',
    'date_placeholder' => 'Seleccionar fecha',
    'add_instructions' => '¿Le gustaría agregar instrucciones especiales?',
    'add_instructions_placeholder' => 'Escriba cualquier instrucción especial aquí (Opcional)',
    'select_date_title' => 'Seleccione la hora adecuada para la reserva',
    'select_date_info' => '* Las ranuras reservadas están deshabilitadas. Seleccione la próxima fecha si se toman todas las ranuras.',
    'address_error' => 'Por favor, proporcione la dirección de reserva.',
    'date_error' => 'Seleccione una fecha para su reserva.',
    'time_slot_error' => 'Por favor, seleccione la hora de su reserva.',
    'package_type_error' => 'Seleccione Tipo de Juego',
    'tennis_slot_error' => 'No hay disponibles horarios suficientes para el tipo de juego seleccionado',
    'draw_user_error' => 'Usuario ya tiene registro en sorteo seleccionado',
    'no_extra_services_title' => 'No se ofrecen servicios adicionales para su tipo de reserva.',
    'no_extra_services_subtitle' => 'Haga clic en el botón de abajo para finalizar su reserva por favor.',
    'add_service_title' => '¿Desea agregar alguno de estos servicios adicionales?',
    'add_service_btn' => 'Agregar a la reserva',
    'remove_service_btn' => 'Eliminar de la reserva',
    'update_service_btn' => 'Actualizar Reserva',

    'booking_summary' => 'Resumen de reserva',
    'booking_details' => 'Detalles de reserva',
    'total' => 'Total',
    'gst' => 'VAT',
    'grand_total' => 'Gran Total',
    'pay_with_card' => 'Paga con tarjeta de crédito',
    'card_number' => 'Número de tarjeta',
    'card_exp_month' => 'Mes',
    'card_exp_year' => 'Año',
    'pay_with_paypal' => 'Pagar con PayPal',
    'stripe_sandbox_notice' => 'Stripe sandbox está habilitado. Su pago no se realizará en modo directo.',
    'paypal_sandbox_notice' => 'Paypal sandbox está habilitado. Su pago no se realizará en modo directo.',
    'paypal_redirect_notice' => 'Será redirigido a Paypal para completar su pago de forma segura.',
    'no_gateway_error' => 'No hay una puerta de enlace de pago habilitada.',
    'thank_you_title' => 'Reserva completada',
    'thank_you_subtitle' => 'Se envía una confirmación y una factura a su dirección de correo electrónico.',
    'thank_you_heading' => 'Gracias por reservar con nosotros.',
    'thank_you_paragraph' => 'Los detalles completos sobre su reserva y la factura de su pago ya se enviaron a su dirección de correo electrónico. También puede iniciar sesión en su cuenta para rastrear sus reservas y facturas en cualquier momento.',
    'new_booking_link' => 'Nueva Reserva',
    'payment_failed_title' => '¡Lo siento! Algo salió mal',
    'payment_failed_subtitle' => 'No podemos procesar su reserva.',
    'payment_failed_heading' => 'Lo sentimos',
    'payment_failed_paragraph' => 'Probablemente sea porque no pudimos procesar su pago, pero siempre puede intentar con otro método de pago en cualquier momento. Si ha completado su transacción con éxito. Por favor consúltenos en',
    'or' => 'y',
    'try_again' => 'Intentémoslo de nuevo',
    'administrator' => 'Administrador',
    'customer' => 'Cliente',
    //'offline_payment_heading' => 'Reserve Ahora y Pague Después del Servicio',
	'offline_payment_heading' => 'Reserve Ahora y Pague en el Starter',
    'complete_booking' => 'Finaliza la Reserva',
];
