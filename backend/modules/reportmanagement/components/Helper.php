<?php
namespace app\modules\reportmanagement\components;

require dirname(dirname(__FILE__)).'/components/phpexcel/PHPExcel.php';
class Helper
{
	//充值报表导出
	public static function CreateExcelReportingList($result){
		header("content-type:text/html;charset=utf-8");
		/** Error reporting */
		error_reporting(E_ALL);
		/** PHPExcel */
		//include_once '../themes/ace/assets/js/PHPExcel/PHPExcel.php';
	
		/** PHPExcel_Writer_Excel2003用于创建xls文件 */
		//include_once '../themes/ace/assets/js/PHPExcel/PHPExcel/Writer/Excel5.php';
	
		// Create new PHPExcel object
		$objPHPExcel = new \PHPExcel();
	
		// Set properties
		//$objPHPExcel->getProperties()->setCreator("李汉团");
		//$objPHPExcel->getProperties()->setLastModifiedBy("李汉团");
		$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
		$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
		$objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");
	
		// Add some data
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', '姓名');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', '船员类型');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', '性别');
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', '护照号');
		$objPHPExcel->getActiveSheet()->SetCellValue('E1', '房间号');
		$objPHPExcel->getActiveSheet()->SetCellValue('F1', '港口');
		$objPHPExcel->getActiveSheet()->SetCellValue('G1', '上落点');
		$objPHPExcel->getActiveSheet()->SetCellValue('H1', '时间');
		$objPHPExcel->getActiveSheet()->SetCellValue('I1', '类型');
		
		foreach ($result as $k=>$v){
			$index = 'A'.($k+2);
			$index_b = 'B'.($k+2);
			$index_c = 'C'.($k+2);
			$index_d = 'D'.($k+2);
			$index_e = 'E'.($k+2);
			$index_f = 'F'.($k+2);
			$index_g = 'G'.($k+2);
			$index_h = 'H'.($k+2);
			$index_i = 'I'.($k+2);
			
			$objPHPExcel->getActiveSheet()->SetCellValue($index, $v['member_name']);
			$objPHPExcel->getActiveSheet()->SetCellValue($index_b, $v['member_type']);
			$objPHPExcel->getActiveSheet()->SetCellValue($index_c, $v['gender']);
			$objPHPExcel->getActiveSheet()->SetCellValue($index_d, $v['passport_number']);
			$objPHPExcel->getActiveSheet()->SetCellValue($index_e, $v['cabin_name']);
			$objPHPExcel->getActiveSheet()->SetCellValue($index_f, $v['port_name']);
			$objPHPExcel->getActiveSheet()->SetCellValue($index_g, $v['gangway_number']);
			$objPHPExcel->getActiveSheet()->SetCellValue($index_h, $v['boarding_time']);
			$objPHPExcel->getActiveSheet()->SetCellValue($index_i, $v['gangway_type']);
		}
	
		$time = date('YmdHis',time());
		// Rename sheet
		$objPHPExcel->getActiveSheet()->setTitle($time);
	
		$filename = $time."repoing_excel.xls";
	
		// Save Excel 2007 file
		//$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	
		$objWriter = new \PHPExcel_Writer_Excel5($objPHPExcel);
		ob_start();
		$objWriter->save("php://output");
		$xlsData = ob_get_contents();
		ob_end_clean();
		$response =  array(
			'op' => 'ok',
			'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData),
			'path' => $filename,
		);
		return json_encode($response);
		
		
// 		$objWriter = new \PHPExcel_Writer_Excel5($objPHPExcel);
// 		$objWriter->save($filename);
// 		$objWriter->save(str_replace('.php', '.xls', __FILE__));
// 		header("Pragma: public");
// 		header("Expires: 0");
// 		header("Cache-Control:must-revalidate,post-check=0,pre-check=0");
// 		header("Content-Type:application/force-download");
// 		header("Content-Type:application/vnd.ms-execl");
// 		header("Content-Type:application/octet-stream");
// 		header("Content-Type:application/download");
// 		header("Content-Disposition:attachment;filename=csat.".$filename);
// 		header("Content-Transfer-Encoding:binary");
// 		$objWriter->save("php://output");
	}
	
}