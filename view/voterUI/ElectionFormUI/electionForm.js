// Initialize form submission
$("#submitBtn").click(submitVote);

let positionRules = {
    president: 1,
    vice_president: 1,
    vice_governor: 1,
    senator: 4
};

function disableButton(positionName, checkbox) {
    let boxes = document.querySelectorAll('input[type="checkbox"][name="' + positionName + '"]');
    let ruleMax = positionRules[positionName] || 1;
    let selected = 0;
    
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

//converts a checkbox element to a vote object for submission
function buildVoteObject(checkbox) {
    const candidateId = checkbox.getAttribute('data-candidate-id');
    return {
        candidate_id: candidateId === '' ? null : parseInt(candidateId),
        position_id: parseInt(checkbox.getAttribute('data-position-id'))
    };
}

//converts checkboxes to FormData for AJAX submission
function buildVoteFormData(checkboxes) {
    const formData = new FormData();
    checkboxes.forEach(function(checkbox) {
        formData.append('votes[]', JSON.stringify(buildVoteObject(checkbox)));
    });
    return formData;
}

function submitVote() {
    let chkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
    
    if (chkboxes.length === 0) {
        alert('Please select at least one option');
        return;
    }

    // Validate that all required positions are filled
    const requiredPositions = ['president', 'vice_president', 'senator', 'vice_governor'];
    for (const position of requiredPositions) {
        let selected = document.querySelectorAll('input[type="checkbox"][name="' + position + '"]:checked');
        if (selected.length === 0) {
            alert('Please vote or abstain for ' + position.replace('_', ' '));
            return;
        }
    }

    if (!confirm("Are you sure you want to submit your vote?")) return;

    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.textContent = 'Submitting...';

    const formData = buildVoteFormData(chkboxes);

    $.ajax({
        url: "/VotingSystem/control/electionControl.php",
        type: "post",
        data: formData,
        processData: false,
        contentType: false,
        success: function(res) {
            if (res.success) {
                alert('Vote submitted successfully!');
                window.location.href = '/VotingSystem/index.html';
            } else {
                alert('Error: ' + res.message);
                btn.disabled = false;
                btn.textContent = 'Submit Vote';
            }
        }
    });
}


