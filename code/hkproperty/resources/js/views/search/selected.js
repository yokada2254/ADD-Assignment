const SelectedTypes = {
    'ADD': 1,
    'DEL': 2,
    'UPDTE': 3,
    'CONCAT': 4,
    'CLEAR': 5
}

function selectedReducer(state, action){
    console.log("selectedReducer", state, action);
    switch(action.type){
        case SelectedTypes.ADD:
            return [...state, action.item];

        case SelectedTypes.DEL:
            return state.filter(item => item.id != action.item.id);

        case SelectedTypes.CONCAT:
            let currentIds = state.map(item => item.id);
            let append = action.item.filter(item => !currentIds.includes(item.id));

            return [ ...state, ...append ];

        case SelectedTypes.UPDATE:
            return state.map(item => {
                if(item.id == action.item.id){
                    return action.item;
                }
                return item;
            });

        case SelectedTypes.CLEAR:
            return [];
    }
    return state;
}

module.exports = {
    SelectedTypes, 
    selectedReducer
}