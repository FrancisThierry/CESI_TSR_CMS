<?php 
class Blog {
    public $title;
    public $firstparagraph;
    public $secondparagraph;
    public $image;
    public $link;

    public const author = "Thierry Boulanger";

    // Le mot-clé 'public function' est obligatoire ici
    public function __construct($title, $firstparagraph, $secondparagraph, $image, $link) {
        $this->title = $title;
        $this->firstparagraph = $firstparagraph;
        $this->secondparagraph = $secondparagraph;
        $this->image = $image;
        $this->link = $link;            
    }  

    // Ajout de 'public function' pour les méthodes
    public function getImage() {
        return $this->image;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function getTitle() {
        return $this->title;
    }
    public function setTitle($title) {
        $this->title = $title;
    }
    public function getFirstParagraph() {
        return $this->firstparagraph;
    }
    public function setFirstParagraph($firstparagraph) {
        $this->firstparagraph = $firstparagraph;
    }
    public function getSecondParagraph() {
        return $this->secondparagraph;
    }
    public function setSecondParagraph($secondparagraph) {
        $this->secondparagraph = $secondparagraph;
    }   

    public function getLink() {
        return $this->link;
    }

}