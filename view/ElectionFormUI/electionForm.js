var positionRules = {
    president: 1,
    vice_president: 1,
    vice_governor: 1,
    senator: 5
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
