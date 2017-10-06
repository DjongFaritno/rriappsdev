//load
$(document).ready(function(){

	$('.datepicker').datepicker({
			autoclose: true
		});

	setTable();
	setTableinvoice();
});

function setTable(){
	var idsub =$('#txt_idsub').val()
	var my_table = $('#tb_listx').DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        paging: false,
        ajax: base_url+"pertek/loaddatatablepartinvoice/"+idsub,
        fixedColumns:{
            leftColumns: 0
        },
        bFilter:false,
        dom: "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'l><'col-sm-7'pi>>" 
    });
}

function setTableinvoice(){
	var idpertek =$('#txt_id_Pertek').val()
	var kd_kategori =$('#kd_kategori').val()
	var my_table = $('#tb_listinvoice').DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        paging: false,
        ajax: base_url+"pertek/loaddatatablepertekinvoice/"+idpertek+"/"+kd_kategori,
        fixedColumns:{
            leftColumns: 0
        },
        bFilter:false,
        dom: "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'l><'col-sm-7'pi>>" 
    });
}

function BacktopertekDT1(){
	var nopertek = $('#txt_id_Pertek').val();

			window.location = base_url+'pertek/view_pertek/'+nopertek;

}
