


var positionRules = {
    president: 1,
    vice_president: 1,
    vice_governor: 1,
    senator: 4
};

function disableButton(positionName, checkbox) {
    var boxes = document.querySelectorAll('input[type="checkbox"][name="' + positionName + '"]');
    var ruleMax = positionRules[positionName] || 1;
    var selected = 0;
    
    boxes.forEach(function(box) {
        if (box.checked && box.value !== 'abstain') selected++;
    });
    
    if (checkbox.value === 'abstain' && checkbox.checked) {
        boxes.forEach(function(box) {
            if (box.value !== 'abstain') box.checked = false;
        });
        return;
    }
    
    if (checkbox.checked && selected > ruleMax) {
        checkbox.checked = false;
        alert('Maximum ' + ruleMax + ' allowed for ' + positionName);
        return;
    }
    
    if (checkbox.checked && checkbox.value !== 'abstain') {
        boxes.forEach(function(box) {
            if (box.value === 'abstain') box.checked = false;
        });
    }
}

    // Initialize form submission
    $("#submitBtn").click(submitVote);

    function submitVote() {
        const votes = [];
        document.querySelectorAll('input[type="checkbox"]:checked').forEach(function(checkbox) {
            votes.push({
                candidate_id: parseInt(checkbox.getAttribute('data-candidate-id')),
                position_id: parseInt(checkbox.getAttribute('data-position-id'))
            });
        });

        if (!confirm("Are you sure you want to submit your vote?")) return;

        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.textContent = 'Submitting...';

        $.ajax({
            url: "../../control/submitVote.php",
            type: "post",
            contentType: "application/json",
            data: JSON.stringify(votes),
            success: function(res) {
                if (res.success) {
                    alert('Vote submitted successfully!');
                    window.location.href = '../../index.html';
                } else {
                    alert('Error: ' + res.message);
                    btn.disabled = false;
                    btn.textContent = 'Submit Vote';
                }
            }
        });
    }
