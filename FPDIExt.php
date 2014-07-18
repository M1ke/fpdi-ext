<?php
class FPDIExt extends FPDI {
	public $template=null;
	public $template_size=[];
	protected $use_template_size=false;

	function block_image($image_file,$x,$y){
		list($width,$height)=getimagesize($image_file);
		$width/=3;
		$this->Image($image_file,$x-($width/2),$y,-300);
		return $this;
	}

	function block_text($text,$x,$y){
		$this->Text($x-($this->GetStringWidth($text)/2),$y,$text);
		return $this;
	}

	function draw_grid(){
		for ($pos=10;$pos< 791;$pos=$pos+10){
			if ($pos%100==0){
				$this->SetDrawColor(0,0,200);
				$this->SetLineWidth(1);
			}
			elseif ($pos%50==0){
				$this->SetDrawColor(200,0,0);
				$this->SetLineWidth(.05);
			}
			else {
				$this->SetDrawColor(128,128,128);
				$this->SetLineWidth(.05);
			}
			$this->Line(0, $pos,611,$pos);
			if ($pos<611){
				$this->Line($pos,0,$pos,791);
			}
		}
		$this->SetLineWidth(1);
		$this->SetDrawColor(0,0,0);
		$this->Rect(0,0,612,792,"D");
		return $this;
	}

	function output_inline($file_name){
		$pdf->Output($file_name,'F');
		header('Content-type: application/pdf');
		header('Content-Disposition: inline; filename="'.$file_name.'"');
		header('Content-Length: '.filesize($file_name));
		@readfile($file_name);
		die;
	}

	function load_template($file_name){
		$this->setSourceFile($file_name);
		$this->template=$this->importPage(1);
		$this->template_size=$this->getTemplateSize($this->template);
		return $this;
	}

	function use_template_size(){
		$this->use_template_size=true;
		return $this;
	}

	function add_page_template(){
		if ($this->use_template_size){
			$size=$this->size;
			if ($size['w']>$size['h']){
				$this->AddPage('L',array($size['w'],$size['h']));
			}
			else {
				$this->AddPage('P',array($size['w'],$size['h']));
			}
		}
		else {
			$this->AddPage();
		}
		if (!is_null($this->template)){
			$this->useTemplate($this->template);
		}
		return $this;
	}

	static function template($file_name){
		$fpdf=self::__construct();
		$fpdf->load_template($file_name)->use_template_size();
		return $fpdf;
	}
}