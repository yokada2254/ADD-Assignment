import React, { useState, useReducer } from 'react';
import ReactDOM from 'react-dom';
import PropTypes from 'prop-types';

import { SelectedTypes, selectedReducer } from "../search/selected";

import Details from './details';

function Prefer(props){
    const [items, dispatchItems] = useReducer(selectedReducer, props.items);

    const addItem = () => {
        dispatchItems({
            type: SelectedTypes.ADD,
            item: {
                id: `temp_${Date.now()}`,
                transaction_type_id: 3,
                fm: 0, to: 0
            }
        })
    }

    const updateItem = item => {
        dispatchItems({ type: SelectedTypes.UPDATE, item });
    }
    // console.log("items", items);
    

    const searchPackage = item => {
        let query = new URLSearchParams();
        query.set('price_fm', item['fm']);
        query.set('price_to', item['to']);
        ['room', 'transaction_type_id'].forEach(key => {
            if(item[key] != null)
                query.set(key, item[key]);
        });
        query.set('status_id', '1');
        query.set('submit', '1');
        window.open(`/package?${query}`);
    }

    return (
    <div className="card">
        <div className="card-header d-flex align-items-center justify-content-between">
            <h5 className="font-weight-bold">{ __('prefer.title') }</h5>
        {
            props.disabled?
            <div></div>:
            <button type="button" className="btn btn-sm btn-dark" onClick={addItem} disabled={props.disabled}>
                <i className="fas fa-plus mr-2"></i>{__('form.add')}
            </button>
        }
        </div>
        <div className="card-body p-0">
        {
            items.map((item, i) => {
                const prefix = item.transaction_type_id == 3 ?
                <div className="input-group-prepend input-group-append">
                    <div className="input-group-text">$</div>
                </div>:<></>;
                const postfix = item.transaction_type_id != 3 ?
                <div className="input-group-prepend input-group-append">
                    <div className="input-group-text">10K</div>
                </div>:<></>;

                return (
                <div className="card my-1" key={`prefer_${i}`}>
                    <input type="hidden" name={`prefer[${i}][id]`} value={/^temp/.test(item.id)?'':item.id} />
                    <div className="card-body">
                        <div className="form-row mb-2">
                            <div className="col-2">
                                <select 
                                    className="form-control-sm form-control" 
                                    name={`prefer[${i}][transaction_type_id]`} value={item.transaction_type_id}
                                    onChange={({target}) => updateItem({...item, transaction_type_id: target.value})}
                                    disabled={props.disabled}
                                >
                                {
                                    window._transaction_types.map(type => (
                                    <option value={type.id} key={`type_${type.id}`}>{type.name}</option>))
                                }
                                </select>
                            </div>
                            <div className="col-5">
                                <div className="input-group input-group-sm">
                                    <div className="input-group-prepend">
                                        <div className="input-group-text">{ __('prefer.price') }</div>
                                    </div>

                                    { prefix }

                                    <input 
                                        type="text" className="form-control-sm form-control text-right" 
                                        name={`prefer[${i}][fm]`} value={item.fm}
                                        onChange={({target}) => updateItem({...item, fm: target.value})}
                                        disabled={props.disabled}
                                    />

                                    { postfix }
                                    
                                    <div className="input-group-prepend input-group-append">
                                        <div className="input-group-text">{ __('form.to') }</div>
                                    </div>

                                    { prefix }

                                    <input 
                                        type="text" className="form-control-sm form-control text-right"  
                                        name={`prefer[${i}][to]`} value={item.to} 
                                        onChange={({target}) => updateItem({...item, to: target.value})}
                                        disabled={props.disabled}
                                    />

                                    { postfix }

                                </div>
                            </div>
                            
                            <div className="col-3">
                                <div className="input-group input-group-sm">
                                    <div className="input-group-prepend">
                                        <div className="input-group-text">{ __('property.room') }</div>
                                    </div>
                                    <input 
                                        className="form-control form-control-sm" type="text" 
                                        name={`prefer[${i}][room]`} value={item.room} 
                                        onChange={({target}) => updateItem({...item, room: target.value})}
                                        disabled={props.disabled}
                                    />
                                </div>
                            </div>

                            <div className="col-2">
                            {
                                props.disabled?
                                <a
                                    className="btn btn-block btn-sm btn-primary"
                                    onClick={() => searchPackage(item)}
                                >
                                    <i className="fas fa-search"></i>
                                </a>:
                                <button 
                                    className="btn btn-block btn-sm btn-danger" type="button" 
                                    onClick={() => dispatchItems({type: SelectedTypes.DEL, item})}
                                    disabled={props.disabled}
                                >
                                    <i className="fas fa-times"></i>
                                </button>
                            }
                            </div>
                        </div>
                        <Details index={i} item={item} items={item.area_districts} disabled={props.disabled} />
                    </div>
                </div>)
            })
        }
        </div>
        <div className="card-footer">

        </div>
    </div>)
}

Prefer.propTypes = {
    items: PropTypes.array,
    disabled: PropTypes.bool
}

Prefer.defaultProps = {
    items: [],
    disabled: false
}

export default Prefer;

document.querySelectorAll("prefer").forEach(dom => {
    let props = Object.assign({}, dom.dataset);
    if(!!props.items){
        props.items = JSON.parse(props.items).map(item => {
            item.transaction_type_id = parseInt(item.transaction_type_id);
            item.fm = parseInt(item.fm);
            item.to = parseInt(item.to);
            return item;
        });
        if(!!props.disabled) props.disabled = props.disabled == "true";
    }

    ReactDOM.render(<Prefer {...props} />, dom);
});