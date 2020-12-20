import React, { useState, useReducer } from 'react';
import ReactDOM from 'react-dom';
import PropTypes from 'prop-types';

import { SelectedTypes, selectedReducer } from './selected';

import People from './people';

function Owner({items}){
    const [show, setShow] = useState(false);
    const [owners, dispatchOwners] = useReducer(selectedReducer, items);

    const onClose = items => {
        setShow(false);
        dispatchOwners({
            type: SelectedTypes.CONCAT,
            item: items
        })
    }

    return (
    <div className="form-row py-1">
        <div className="col-12">
            <div className="input-group input-group-sm">
                <div className="input-group-prepend">
                    <div className="input-group-text">{ __('property.owner') }</div>
                </div>

                <div className="form-control">
                    <div className="d-flex align-items-center justify-content-start flex-wrap">
                {
                    owners.map(item => (
                    <>
                        <a 
                            key={item.id} onClick={() => dispatchOwners({type: SelectedTypes.DEL, item})}
                            className="m-1 badge badge-pill badge-secondary">
                            {item.name}
                            <i className="ml-2 fas fa-times-circle"></i>
                        </a>
                        <input type="hidden" name="owner_id[]" value={item.id} />
                    </>))   
                }
                    </div>
                </div>
                
                <div className="input-group-append">
                    <div className="btn btn-secondary" onClick={() => setShow(true)}>
                        <i className="fas fa-search"></i>
                    </div>
                </div>
            </div>
        </div>
        <People show={show} onClose={onClose} />
    </div>)
}

Owner.defaultProps = {
    items: []
}

Owner.propTypes = {
    items: PropTypes.array
}

document.querySelectorAll('owner').forEach(dom => {
    let props = Object.assign({}, dom.dataset);
    if(!!props.items) props.items = JSON.parse(props.items);
    console.log("props", props);

    ReactDOM.render(<Owner {...props} />, dom);
});

export default Owner;