$(document).ready(function() {
    $.ajax({
        url: 'php/getPartitions.php',
        method: 'get',
        dataType: 'json'
    }).done(function(data) {
        if (data.success === true) {
            if (data.hasOwnProperty('partitions')) {
                for (let cptPartition = 0; cptPartition < data.partitions.length; cptPartition++) {
                    $("body").prepend(
                        $("<p />").html(data.partitions[cptPartition]['title']).click(function() {
                            $("#partition").html('');
                            loadPartition(data.partitions[cptPartition]['id_partition'])
                        })
                    )
                }
            }
        }
    })
})

function loadPartition(partition) {
    $.ajax({
        url: 'php/getAccord.php',
        method: 'post',
        dataType: 'json',
        data: { id_partition: partition }
    }).done(function(data) {
        if (data.success === true) {
            if (data.hasOwnProperty('partition')) {
                console.log(data.partition.length)
                for (let cptAccord = 0; cptAccord < data.partition.length; cptAccord++) {
                    $("#partition").append(
                        createAccord(data.partition[cptAccord])
                    )
                }
            }
        } else {
            if (data.hasOwnProperty('message')) {
                $("#partition").append($('<p/>').html(data.message));
            }
            $('body').prepend($('<p/>').html('Une erreur est survenus'));
        }

    }).fail(function() {
        alert("ERREUR");
    });
}
let createAccord = function(accord) {
    let tableAccord = $('<table/>').addClass('AccordTable').attr('id', 'AccordNumero' + accord['id_accord']);
    for (var cptIndex = 9; cptIndex >= 0; cptIndex--) {
        let Maligne = $('<tr/>').addClass('LigneSolfege');
        let Macase = $('<th/>');
        if (accord['index_accord'] == cptIndex) {
            Macase.addClass('note');
        }
        Maligne.append(Macase);
        tableAccord.append(Maligne);
    }
    return tableAccord;
}