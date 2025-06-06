<?php
//7.1 Classes (Métodos e Atributos)
class Tipo {
    private $cd_tip;
    private $nome;
    private $descricao;

    public function __construct($cd_tip = null, $nome = null, $descricao = null) {
        $this->cd_tip = $cd_tip;
        $this->nome = $nome;
        $this->descricao = $descricao;
    }

    public function getCdTip() {
        return $this->cd_tip;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }
}

class Pessoa {
    protected $cd_pessoa;
    protected $nome;

    public function __construct($cd_pessoa = null, $nome = null) {
        $this->cd_pessoa = $cd_pessoa;
        $this->nome = $nome;
    }

    public function getCdPessoa() {
        return $this->cd_pessoa;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }
}

class Aluno extends Pessoa {
    public function __construct($cd_aluno = null, $nome = null) {
        parent::__construct($cd_aluno, $nome);
    }

    public function getCdAluno() {
        return $this->cd_pessoa; // Herda o ID como cd_aluno
    }
}

class Professor extends Pessoa {
    public function __construct($cd_prof = null, $nome = null) {
        parent::__construct($cd_prof, $nome);
    }

    public function getCdProf() {
        return $this->cd_pessoa; // Herda o ID como cd_prof
    }
}

class Orientador extends Professor {
    public function __construct($cd_prof = null, $nome = null) {
        parent::__construct($cd_prof, $nome);
    }
}

//7.4 Instanciação de Objetos
class Tcc {
    private $cd_tcc;
    private $titulo;
    private $data_cad;
    private $tipo; // Objeto da classe Tipo
    private $orientador; // Objeto da classe Orientador
    private $coorientador; // Objeto da classe Professor (pode ser null)
    private $aluno1; // Objeto da classe Aluno
    private $aluno2; // Objeto da classe Aluno (pode ser null)
    private $aluno3; // Objeto da classe Aluno (pode ser null)

    public function __construct(
        $cd_tcc = null,
        $titulo = null,
        $data_cad = null,
        Tipo $tipo = null,
        Orientador $orientador = null,
        Professor $coorientador = null,
        Aluno $aluno1 = null,
        Aluno $aluno2 = null,
        Aluno $aluno3 = null
    ) {
        $this->cd_tcc = $cd_tcc;
        $this->titulo = $titulo;
        $this->data_cad = $data_cad;
        $this->tipo = $tipo;
        $this->orientador = $orientador;
        $this->coorientador = $coorientador;
        $this->aluno1 = $aluno1;
        $this->aluno2 = $aluno2;
        $this->aluno3 = $aluno3;
    }

    public function getCdTcc() {
        return $this->cd_tcc;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getDataCad() {
        return $this->data_cad;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getOrientador() {
        return $this->orientador;
    }

    public function getCoorientador() {
        return $this->coorientador;
    }

    public function getAluno1() {
        return $this->aluno1;
    }

    public function getAluno2() {
        return $this->aluno2;
    }

    public function getAluno3() {
        return $this->aluno3;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function setDataCad($data_cad) {
        $this->data_cad = $data_cad;
    }

    public function setTipo(Tipo $tipo) {
        $this->tipo = $tipo;
    }

    public function setOrientador(Orientador $orientador) {
        $this->orientador = $orientador;
    }

    public function setCoorientador(Professor $coorientador = null) {
        $this->coorientador = $coorientador;
    }

    public function setAluno1(Aluno $aluno1) {
        $this->aluno1 = $aluno1;
    }

    public function setAluno2(Aluno $aluno2 = null) {
        $this->aluno2 = $aluno2;
    }

    public function setAluno3(Aluno $aluno3 = null) {
        $this->aluno3 = $aluno3;
    }
}

class AgendaTcc {
    private $cd_agenda;
    private $tcc; // Objeto da classe Tcc
    private $data_def;
    private $prof_conv1; // Objeto da classe Professor (pode ser null)
    private $prof_conv2; // Objeto da classe Professor (pode ser null)

    public function __construct(
        $cd_agenda = null,
        Tcc $tcc = null,
        $data_def = null,
        Professor $prof_conv1 = null,
        Professor $prof_conv2 = null
    ) {
        $this->cd_agenda = $cd_agenda;
        $this->tcc = $tcc;
        $this->data_def = $data_def;
        $this->prof_conv1 = $prof_conv1;
        $this->prof_conv2 = $prof_conv2;
    }

    public function getCdAgenda() {
        return $this->cd_agenda;
    }

    public function getTcc() {
        return $this->tcc;
    }

    public function getDataDef() {
        return $this->data_def;
    }

    public function getProfConv1() {
        return $this->prof_conv1;
    }

    public function getProfConv2() {
        return $this->prof_conv2;
    }

    public function setTcc(Tcc $tcc) {
        $this->tcc = $tcc;
    }

    public function setDataDef($data_def) {
        $this->data_def = $data_def;
    }

    public function setProfConv1(Professor $prof_conv1 = null) {
        $this->prof_conv1 = $prof_conv1;
    }

    public function setProfConv2(Professor $prof_conv2 = null) {
        $this->prof_conv2 = $prof_conv2;
    }
}

?>