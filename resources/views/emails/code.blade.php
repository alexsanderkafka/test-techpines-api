<!-- resources/views/emails/code.blade.php -->
<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px;">
    <h2 style="color: #333; text-align: center;">Login na Top 5 Tião Carreiro e Pardinho</h2>
    
    <p style="font-size: 16px; color: #555; text-align: center;">
        Esse é o seu código para efetuar o login:
    </p>

    <div style="background-color: #fff; padding: 15px; margin: 20px auto; text-align: center; border-radius: 8px; max-width: 220px; border: 5px solid #cc5c00ff;">
        <span style="font-size: 28px; color: #333; font-weight: bold; letter-spacing: 2px;">
            {{ $code }}
        </span>
    </div>

    <p style="font-size: 14px; color: #888; text-align: center;">
        Se você não solicitou essa alteração, ignore este e-mail.
    </p>

    <p style="font-size: 12px; color: #bbb; text-align: center; margin-top: 30px;">
        &copy; 2025 Top 5 Tião Carreiro e Pardinho. Todos os direitos reservados.
    </p>
</div>
