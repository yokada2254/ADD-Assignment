import React, { useReducer } from 'react';
import PropTypes from 'prop-types';

import { SelectedTypes, selectedReducer } from "../search/selected";
import PropertyFields from '../../components/PropertyFields';

function Details(props){
    const [items, dispatchItems] = useReducer(selectedReducer, props.items);
    
    const addItem = () => {
        dispatchItems({
            type: SelectedTypes.ADD,
            item: {
                id: `temp_${Date.now()}`,
                area: "",
                district: "",
                estateType: props.estateType,
                estates: []
            }
        })
    }

    const searchPackage = prefer => {
        const { item } = props;

        let query = new URLSearchParams();
        query.set('price_fm', item['fm']);
        query.set('price_to', item['to']);
        ['room', 'transaction_type_id'].forEach(key => {
            if(item[key] != null)
                query.set(key, item[key]);
        });
        ['area_id', 'district_id'].forEach(key => {
            if(prefer[key] != null)
                query.set(key, prefer[key]);
        });
        prefer.estates.forEach((estate, i) => {
            query.set(`estate_id[${i}]`, estate.id);
        });
        query.set('status_id', '1');
        query.set('submit', '1');
        // console.log(`/package?${query}`);
        window.open(`/package?${query}`);
    }
    
    return (
    <>
    {
        !props.disabled &&
        <button className="btn btn-block btn-dark" type="button" onClick={addItem} disabled={props.disabled}>{ __('form.add') }</button>
    }
        <div className="d-flex flex-wrap">

    {
        items.map((item, i) => {
            let prefix = `prefer[${props.index}][area_district][${i}]`;

            return (
            <div className="card col-xl-6 col-md-12 my-1 p-1" key={`item_${i}`}>
                <input type="hidden" name={`${prefix}[id]`} value={/^temp/.test(item.id)?'':item.id} />
                <PropertyFields 
                    names={{
                        'area': `${prefix}[area_id]`,
                        'district': `${prefix}[district_id]`,
                        'estate': `${prefix}[estate_id][]`,
                    }}
                    key={`property_fields_${i}`} 
                    fields={['area', 'district', 'estate']} 
                    
                    area={item.area_id}
                    district={item.district_id}
                    estates={item.estates}
                    estateType={item.estate_type_id}
                    disabled={props.disabled}
                />
            {
                !props.disabled?
                <button 
                    className="btn btn-sm btn-sm-block btn-danger" type="button" 
                    onClick={() => dispatchItems({type: SelectedTypes.DEL, item})}
                    disabled={props.disabled}
                >
                    <i className="fas fa-times"></i>
                </button>:
                <button className="btn btn-sm btn-primary" type="button" onClick={() => searchPackage(item)}>
                    <i className="fas fa-search"></i>
                </button>
            }
            </div>
            )
        })
    }
        </div>
    </>);
}

Details.propTypes = {
    items: PropTypes.array,
    index: PropTypes.number,
    disabled: PropTypes.bool
}

Details.defaultProps = {
    items: [],
    disabled: false
}

export default Details;