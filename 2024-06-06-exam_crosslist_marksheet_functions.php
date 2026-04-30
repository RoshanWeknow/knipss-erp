<?php
function calculate_grade($marks_obt, $marks_max) {
    //$marks_max = is_int($marks_max)?$marks_max:1;
	if($marks_obt=='Abs'){
		$grade = 0;
	}else{
		if($marks_max=='0'){
			$marksPercent = '';
		}
		else{
			$marksPercent = ($marks_obt * 100) / $marks_max;    
		}
		

		if ($marksPercent >= 91 && $marksPercent <= 100) {
			$grade = 10;
		} elseif ($marksPercent >= 81 && $marksPercent < 91) {
			$grade = 9;
		} elseif ($marksPercent >= 71 && $marksPercent < 81) {
			$grade = 8;
		} elseif ($marksPercent >= 61 && $marksPercent < 71) {
			$grade = 7;
		} elseif ($marksPercent >= 51 && $marksPercent < 61) {
			$grade = 6;
		} elseif ($marksPercent >= 41 && $marksPercent < 51) {
			$grade = 5;
		} elseif ($marksPercent >= 33 && $marksPercent < 41) {
			$grade = 4;
		} elseif ($marksPercent >= 0 && $marksPercent < 33) {
			$grade = 0;
		} elseif ($marksPercent == 'AB(Absent)') {
			$grade = 0;
		} else {
			return 'Invalid GRADE';
		}
	}
    return $grade;
}

function calculate_grade_letter($marks_obt,$marks_max){
	//	$marks_obt = is_int($marks_obt)?$marks_obt:0;
	if($marks_obt=='Abs'){
		$grade_letter = 'AB';
	}else{
		if($marks_max=='0'){
			$marksPercent = '';
		}
		else{
			$marksPercent = ($marks_obt * 100) / $marks_max;    
		}
		
		if($marksPercent >= 91 && $marksPercent <= 100) {
			$grade_letter = 'O';
			$grade = 10;
		} elseif ($marksPercent >= 81 && $marksPercent <= 90) {
		   $grade_letter = 'A+';
		   $grade = 9;
		} elseif ($marksPercent >= 71 && $marksPercent <= 80) {
			$grade_letter =  'A';
			$grade = 8;
		}elseif ($marksPercent >= 61 && $marksPercent <= 70) {
			$grade_letter =  'B+';
			$grade = 7;
		}elseif ($marksPercent >= 51 && $marksPercent <= 60) {
			$grade_letter =  'B';
			$grade = 6;
		}elseif ($marksPercent >= 41 && $marksPercent <= 50) {
			$grade_letter =  'C';
			$grade = 5;
		}elseif ($marksPercent >= 33 && $marksPercent <= 40) {
			$grade_letter =  'D';
			$grade = 4;
		}elseif ($marksPercent >= 0 && $marksPercent <= 32) {
			$grade_letter =  'F';
			$grade = 0;
		}elseif ($marksPercent = 'AB(Absent)' ) {
			$grade_letter =  'AB';
			$grade = 0;
		}elseif ($marksPercent = 'ABS' ) {
			$grade_letter =  'AB';
			$grade = 0;
		} else {
			return 'Invalid letter grade';
		}
	}	
		return $grade_letter;
	
}
function percentage_marks($marks_obt,$marks_max){
	//$marks_obt = is_int($marks_obt)?$marks_obt:0;
	if($marks_max==NULL){
        $marksPercent = 0;
    }elseif($marks_max==0){
        $marksPercent = 0;
    }elseif($marks_obt=='Abs'){
        $marksPercent = 0;
    }
    else{
        $marksPercent = ($marks_obt * 100) / $marks_max;    
    }
	$marksPercent = number_format($marksPercent, 2);
    return $marksPercent;
}

function credit_sum($credit){
	if(is_numeric($credit)){
		$credit_paper = (float)$credit;
	}else{
		$a = $credit;
		list($a1, $a2) = explode("+", $a);
		$credit_paper = (float)$a1+(float)$a2;
	}
	return $credit_paper;
}
function credit_subject($credit,$type,$sub_percentage){
	if($sub_percentage<33){
		$credit_paper_earned = 0;
	}else{
		if(is_numeric($credit=='100')){
			$credit_paper_earned = (float)$credit;
		}else{
			$a = $credit;
			list($a1, $a2) = explode("+", $a);
			if($type=="Theory"){
				$credit_paper_earned = $a1;
			}
			elseif($type=='Practical'){
				$credit_paper_earned = $a2;
			}
		}
	}
	return $credit_paper_earned;
}

?>