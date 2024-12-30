<?php

namespace App\Http\Controllers;

use App\Models\User;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Google2FA;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected Google2FA $google2fa
    ) {}

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $this->middleware('auth');

        $user = User::find(Auth::id()); // Just to call update() method later

        if (!$user->twofa_secret || !$user->twofa_qr) {
            $secret = $this->google2fa->generateSecretKey();
            $encrypted_secret = encrypt($secret);
    
            $qrCodeDataUri = $this->generateQrCode($this->google2fa->getQRCodeUrl(
                config('app.name'),
                $user->email,
                $secret
            ));
    
            $user->update([
                'twofa_secret' => $encrypted_secret,
                'twofa_qr' => $qrCodeDataUri,
            ]);    
        }

        return view('home', [
            'qrCode' => $user->twofa_qr
        ]);
    }

    /**
     * Generate a QR Code image data URI using Bacon QR Code.
     *
     * @param string $qrCodeUrl
     * @return string
     */
    private function generateQrCode(string $qrCodeUrl): string
    {
        $renderer = new ImageRenderer(
            new RendererStyle(300),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);
        $svg = $writer->writeString($qrCodeUrl);

        // Convert SVG to Data URI
        $dataUri = 'data:image/svg+xml;base64,' . base64_encode($svg);

        return $dataUri;
    }

    /**
     * Show the verification page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function verification()
    {
        return view('verification');
    }
}
