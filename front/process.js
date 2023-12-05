$(function() {
    $('table').DataTable();

    // Créer une participation au concours photo en brut
    $('#create').on('click', function(e) {
        let formOrderconcours = $('#formOrderconcours')
        if (formOrderconcours[0].checkValidity()){
            e.preventDefault();
            $.ajax({
                url: 'process.php',
                type: 'post',
                data: formOrderconcours.serialize() + '&action=create',
                succes: function(response) {
                    // console.log(response);
                    $('#create').modale('hide');
                    swal.fire({
                        icon: 'success',
                        titre: 'succès',
                    })
                    formOrderconcours[0].reset();
                }
            })
        }
    })

    // Récupérer les participations
    getBillsCP();
    function getBillsCP() {
        $.ajax({
            url: 'process.php',
            type: 'POST',
            data: { action: 'fetchCP'},
            success: function(response){
                // console.log();
                $('#CPorderTable').html(response);
                $('table').DataTable();
            }
        })
    }
    
    // Supprimer une participation
    $('body').on('click', '.deleteBtn', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Supprimer la participation numéro ?' + this.dataset.id,
            text: "Après ça il sera impossible de récupérer cette participation!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui supprimer!'
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'process.php',
                    type: 'post',
                    data: { deletionId: this.dataset.id},
                    success: function(response){
                        if (response === 1) {
                            Swal.fire(
                                'Supprimer avec succès',
                                'Opération réussite.',
                                'success'
                            )
                            getBillsCP();
                        }
                    }
                })
            }
        })
    })

    $('body').on('click', '.resetBtn', function(e) {
                console.log('bouton cliquer');
        e.preventDefault();

        Swal.fire({
            title: 'Tu vas reset les participations ?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                url: 'process.php',
                type: 'post',
                data: { resetData: true},
                success: function(response){
                    if (response === 'success') {
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )}
                        getBillsCP();
                }
              });
            }
          });
    })

    // Récupérer les votes
    getBillsRCP();
    function getBillsRCP() {
        $.ajax({
            url: 'process.php',
            type: 'post',
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


