<?php

namespace App\Service;

class ImageService {

	const REDIM_CONTAIN = 'REDIM_CONTAIN';
	const REDIM_COVER = 'REDIM_COVER';

	public $tabErreur = [];
	private $chemin;
	private $largeur;
	private $hauteur;
	private $type;

	public function __construct($chemin) {
		$this->chemin = $chemin;
		if (!$tab = @getimagesize($this->chemin)) {
			$this->tabErreur[] = 'Not An Image';
                        return;
		}
		list($this->largeur, $this->hauteur, $this->type) = $tab;
		if ($this->type != IMG_JPG && $this->type != IMG_PNG) {
			$this->tabErreur[] = 'Invalid Mime Type';
		}
	}

	public function copier($largeurCadreDest, $hauteurCadreDest, $cheminDest, $modeRedim = self::REDIM_COVER, $qualite = null) {
		if (!$qualite) {
			$qualite = $this->type == IMG_JPG ? 60 : 6;
		}
		$xSrc = 0;
		$ySrc = 0;
		$ratioSrc = $this->largeur / $this->hauteur;
		$ratioDest = $largeurCadreDest / $hauteurCadreDest;
		if ($modeRedim == self::REDIM_CONTAIN) {
			$largeurSrc = $this->largeur;
			$hauteurSrc = $this->hauteur;
			if ($this->largeur <= $largeurCadreDest && $this->hauteur <= $hauteurCadreDest) {
				if (!copy($this->chemin, $cheminDest)) {
					$this->tabErreur[] = 'Write Access Denied';
				}
				return;
			}
			if ($ratioSrc < $ratioDest) {
				$hauteurDest = $hauteurCadreDest;
				$largeurDest = $hauteurDest * $ratioSrc;
			} else {
				$largeurDest = $largeurCadreDest;
				$hauteurDest = $largeurDest / $ratioSrc;
			}
		} elseif ($modeRedim == self::REDIM_COVER) {
			if ($this->largeur == $largeurCadreDest && $this->hauteur == $hauteurCadreDest) {
				if (!copy($this->chemin, $cheminDest)) {
					$this->tabErreur[] = 'Write Access Denied';
				}
				return;
			}
			if ($ratioSrc < $ratioDest) {
				$ratioRedim = $largeurCadreDest / $this->largeur;
				$hauteurSrc = $hauteurCadreDest / $ratioRedim;
				$largeurSrc = $this->largeur;
				$ySrc = ($this->hauteur - $hauteurSrc) / 2;
			} else {
				$ratioRedim = $hauteurCadreDest / $this->hauteur;
				$largeurSrc = $largeurCadreDest / $ratioRedim;
				$hauteurSrc = $this->hauteur;
				$xSrc = ($this->largeur - $largeurSrc) / 2;
			}
			$largeurDest = $largeurCadreDest;
			$hauteurDest = $hauteurCadreDest;
		}
		if (!$resSrc = $this->type == IMG_JPG ? imagecreatefromjpeg($this->chemin) : imagecreatefrompng($this->chemin)) {
			$this->tabErreur[] = 'Server Out Of Memory';
			return;
		}
		if (!$resDest = imagecreatetruecolor($largeurDest, $hauteurDest)) {
			$this->tabErreur[] = 'Server Out Of Memory';
			return;
		}
		if (!imagecopyresampled($resDest, $resSrc, 0, 0, $xSrc, $ySrc, $largeurDest, $hauteurDest, $largeurSrc, $hauteurSrc)) {
			$this->tabErreur[] = 'Server Out Of Memory';
			return;
		}
		if (!($this->type == IMG_JPG ? imagejpeg($resDest, $cheminDest, $qualite) : imagepng($resDest, $cheminDest, $qualite))) {
			$this->tabErreur[] = 'Write Access Denied';
			return;
		}
		imagedestroy($resSrc);
		imagedestroy($resDest);
	}
        
        function getTabErreur() {
            return $this->tabErreur;
        }



}
