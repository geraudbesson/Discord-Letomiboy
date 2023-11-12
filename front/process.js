$(function() {
    $('table').DataTable();

    // Récupérer les participations
    getBills();
    function getBills(){
        $.ajax({
            url: 'process.php',
            type: 'POST',
            data: { action: 'fetch'},
            success: function(response){
                $('#CPorderTable').html(response);
                $('table').DataTable();
            }
        })
    }
    
    // Récupérer les votes
    getBills();
    function getBills(){
        $.ajax({
            url: 'process.php',
            type: 'POST',
            data: { action: 'fetchRCP'},
            success: function(response){
                // console.log();
                $('#RCPorderTable').html(response);
                $('table').DataTable({
                });
            }
        })
    }

})


