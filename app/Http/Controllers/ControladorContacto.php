<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ControladorContacto extends Controller
{
    // Método central SMTP — lo usan los demás métodos
    public function enviarEmail(string $destinatario, string $asunto, string $cuerpo): bool
    {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'germay1814@gmail.com';
            $mail->Password   = 'wejv potz vuvu dujp';
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('germay1814@gmail.com', 'CoffeeTime');
            $mail->addAddress($destinatario);
            $mail->isHTML(true);
            $mail->Subject = $asunto;
            $mail->Body    = $cuerpo;

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    // Formulario de contacto
    public function enviar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'fecha_envio' => 'required|date',
            'hora_envio' => 'required|string|max:50',
            'mensaje' => 'required|string',
        ]);

        $cuerpo = '
            <h2>Nueva consulta recibida</h2>
            <p><strong>Nombre:</strong> ' . $request->nombre . ' ' . $request->apellidos . '</p>
            <p><strong>Email:</strong> ' . $request->email . '</p>
            <p><strong>Fecha:</strong> ' . $request->fecha_envio . ' ' . $request->hora_envio . '</p>
            <p><strong>Mensaje:</strong></p>
            <p>' . $request->mensaje . '</p>
        ';

        $enviado = $this->enviarEmail('germay1814@gmail.com', 'Nueva consulta de ' . $request->nombre, $cuerpo);

        return response()->json([
            'status'  => $enviado ? 200 : 500,
            'message' => $enviado ? 'Mensaje enviado correctamente.' : 'Error al enviar el mensaje.',
        ]);
    }

    // Confirmación de inscripción a evento
    public function confirmarInscripcion(string $nombre, string $apellidos, string $email,
    string $titulo, string $fecha, string $hora,string $enlace, string $nivel,string $nombreProfesor, string $apellidosProfesor):bool {

    $cuerpo = '
        <h2>¡Inscripción confirmada!</h2>
        <p><strong>Alumno:</strong> ' . $nombre . ' ' . $apellidos . '</p>
        <p><strong>Evento:</strong> ' . $titulo . '</p>
        <p><strong>Fecha:</strong> ' . $fecha . '</p>
        <p><strong>Hora:</strong> ' . $hora . '</p>
        <p><strong>Nivel:</strong> ' . $nivel . '</p>
        <p><strong>Profesor:</strong> ' . $nombreProfesor . ' ' . $apellidosProfesor . '</p>
        <p><strong>Enlace:</strong> <a href="' . $enlace . '">Unirse al evento</a></p>
    ';

    return $this->enviarEmail($email, '¡Inscripcion confirmada! ' . $titulo, $cuerpo);
}

// CANCELACIÓN de EVENTO
public function confirmarCancelacion(
    string $nombre, string $apellidos, string $email, string $titulo, string $fecha, string $hora): bool {

    $cuerpo = '
        <h2>Inscripción cancelada</h2>
        <p><strong>Alumno:</strong> ' . $nombre . ' ' . $apellidos . '</p>
        <p><strong>Evento:</strong> ' . $titulo . '</p>
        <p><strong>Fecha:</strong> ' . $fecha . '</p>
        <p><strong>Hora:</strong> ' . $hora . '</p>
        <p>Si fue un error, puedes volver a inscribirte desde la sección de Eventos.</p>
    ';

    return $this->enviarEmail($email, 'Inscripcion cancelada: ' . $titulo, $cuerpo);
}
}
