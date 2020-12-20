import React, { useState, useEffect, useMemo, useRef, useReducer } from 'react';
import ReactDOM from 'react-dom';
import PropTypes from 'prop-types';
import { SelectedTypes, selectedReducer } from '../views/search/selected';

import Pages from '../components/Pages';

function PropertyFields(props){
    const searchTimer = useRef(undefined);

    const {fields} = props;
    const needArea = fields.includes('area'), 
        needDistrict = fields.includes('district'), 
        needEstateType = fields.includes('estate_type'), 
        needEstate = fields.includes('estate'), 
        needStructure = fields.includes('structure'),
        needFullAddress = fields.includes('full_address');

    const areasDistricts = window._property_options.areas_districts;
    const estateTypes = window._property_options.estate_types;


    const [area, setArea] = useState(props.area);
    const [district, setDistrict] = useState(props.district);
    const [estateType, setEstateType] = useState(props.estateType);
    const [estates, dispatchEstate] = useReducer(selectedReducer, props.estates);

    const [block, setBlock] = useState(props.block);
    const [floor, setFloor] = useState(props.floor);
    const [flat, setFlat] = useState(props.flat);
    const [room, setRoom] = useState(props.room);
    const [grossSizeFm, setGrossSizeFm] = useState(props.grossSizeFm);
    const [grossSizeTo, setGrossSizeTo] = useState(props.grossSizeTo);

    const [keyword, setKeyword] = useState("");
    const [estateList, setEstateList] = useState([]);
    const [currentPage, setCurrentPage] = useState(0);
    const [lastPage, setLastPage] = useState(0);
    const [noRecord, setNoRecord] = useState(false);

    const selectedArea = useMemo(() => areasDistricts.filter(item => item.id == parseInt(area)).pop(), [area])

    useEffect(() => { 
        if(props.reset > 0){
            reset(); 
        }
    }, [props.reset]);

    const reset = () => {
        setArea(props.area);
        setDistrict(props.district);
        setEstateType(props.estateType);
        dispatchEstate({type: SelectedTypes.CLEAR});
        setKeyword("");
        setEstateList([]);
        setCurrentPage(0);
        setLastPage(0);
    }

    useEffect(() => {
        if(!area) setDistrict("");
    }, [area, district])

    useEffect(() => {
        clearTimeout(searchTimer.current);
        searchTimer.current = undefined;

        if(!!keyword){
            searchTimer.current = setTimeout(getEstates, 500);
        }else{
            setEstateList([]);
        }
    }, [keyword, area, district, estateType])
    
    const getEstates = (page = 1) => {
        setEstateList([]);
        setNoRecord(false);

        let params = new URLSearchParams();
        params.set("area_id", area);
        params.set("district_id", district);
        params.set("estate_type_id", estateType);
        params.set("keyword", keyword);
        params.set("page", page);

        fetch(`/estate?${params}`, {method: "GET", headers: {'accept': 'application/json'}})
            .then(res => res.json())
            .then(res => {
                if(res.data.length > 0){
                    setCurrentPage(res.current_page);
                    setLastPage(res.last_page);
                    setEstateList(res.data);
                }else{
                    setNoRecord(true);
                }
            })
            .catch(err => {
                console.error("getEstates", err);
            })
            .finally(() => {
                clearTimeout(searchTimer.current);
                searchTimer.current = undefined;
            });
    }

    const selectedEstateId = estates.map(item => item.id);

    return (
    <>
        <div className="form-row py-1">
        {
            needArea &&
            <div className="input-group input-group-sm col">
                <div className="input-group-prepend">
                    <div className="input-group-text">Area</div>
                </div>
                <select 
                    className="form-control form-control-sm" 
                    name={`${props.names.area}`} value={area}
                    onChange={({target}) => setArea(target.value)} 
                    disabled={props.disabled}
                >
                    <option value="">Select</option>
                {
                    areasDistricts.map(item => (
                    <option value={item.id} key={`area_${item.id}`}>{item.name}</option>))
                }
                </select>
            </div>
        }

        {
            needDistrict &&
            <div className="input-group input-group-sm col">
                <div className="input-group-prepend">
                    <div className="input-group-text">District</div>
                </div>
                <select 
                    className="form-control form-control-sm" 
                    name={`${props.names.district}`} value={district}
                    onChange={({target}) => setDistrict(target.value)} 
                    disabled={props.disabled}
                >
                    <option value="">Select</option>
                {
                    selectedArea?.districts.map(item => (
                    <option value={item.id} key={`district_${item.id}`}>{item.name}</option>))
                }
                </select>
            </div>
        }

        {
            needEstateType &&
            <div className="input-group input-group-sm col">
                <div className="input-group-prepend">
                    <div className="input-group-text">Type</div>
                </div>
                <select 
                    className="form-control form-control-sm" 
                    name={`${props.names.estateType}`} value={estateType}
                    onChange={({target}) => setEstateType(target.value)} 
                    disabled={props.disabled}
                >
                    <option value="">Select</option>
                {
                    estateTypes.map(item => (
                    <option value={item.id} key={`estate_type_${item.id}`}>{item.name}</option>))
                }
                </select>
            </div>
        }
        </div>

    {
        needEstate && !props.disabled &&
        <div className="form-row py-1">
            <div className="input-group input-group-sm col-12">
                <div className="input-group-prepend">
                    <div className="input-group-text">Search</div>
                </div>
                <input 
                    className="form-control form-control-sm" 
                    type="text" value={keyword} 
                    onChange={({target}) => setKeyword(target.value)} 
                    disabled={props.disabled}
                />
            {
                !!keyword &&
                <div className="dropdown-menu show">
                {
                    noRecord ?
                    <h3 className="font-weight-bold text-center">{window.__('form.norecord')}</h3>:
                    estateList.length > 0?
                    estateList.filter(estate => !selectedEstateId.includes(estate.id)).map(item => (
                    <a className="dropdown-item" href="#" key={`estate_${item.id}`} 
                        onClick={() => dispatchEstate({type: SelectedTypes.ADD, item})}>{item.name}
                    </a>)):
                    !!searchTimer.current &&
                    <div className="spinner-border text-primary d-block mx-auto" role="status">
                        <span className="sr-only"></span>
                    </div>
                }
                {
                    lastPage > 1 &&
                    <Pages updateFunc={getEstates} {...{currentPage, lastPage}} />
                }

                    <a href="#" className="dropdown-item text-center" onClick={() => {setEstateList([]); setKeyword("");}}>
                        <i className="fas fa-times-circle"></i>
                    </a>
                </div>
            }
            </div>
        </div>
    }
    
    {
        needEstate && estates.length > 0 &&
        <div className="form-row py-1">
        {
            estates.map(item => (
            <a 
                key={`estate_${item.id}`}
                href="#" className="badge badge-pill badge-secondary m-1" 
                onClick={() => !props.disabled && dispatchEstate({type: SelectedTypes.DEL, item})}>
                {item.name}
            {
                !props.disabled &&
                <i className="fas fa-times-circle ml-2"></i>
            }
                <input type="hidden" name={`${props.names.estate}`} value={item.id} />
            </a>))
        }
        </div>
    }

    {
        <div className="form-row">
        {
            needFullAddress &&
            <>
            <div className="col-auto col-lg-2 col-sm-4 py-2">
                <div className="input-group input-group-sm">
                    <div className="input-group-prepend">
                        <div className="input-group-text">{__('property.block')}</div>
                    </div>
                    <input 
                        className="form-control form-control-sm" 
                        type="text" name="block" value={block} 
                        onChange={({target}) => setBlock(target.value)} 
                        disabled={props.disabled}
                    />
                </div>
            </div>
            
            <div className="col-auto col-lg-2 col-sm-4 py-2">
                <div className="input-group input-group-sm">
                    <div className="input-group-prepend">
                        <div className="input-group-text">{window.__('property.floor')}</div>
                    </div>
                    <input 
                        className="form-control form-control-sm" 
                        type="text" name="floor" value={floor} 
                        onChange={({target}) => setFloor(target.value)} 
                        disabled={props.disabled}
                    />
                </div>
            </div>
            
            <div className="col-auto col-lg-2 col-sm-4 py-2">
                <div className="input-group input-group-sm">
                    <div className="input-group-prepend">
                        <div className="input-group-text">{__('property.flat')}</div>
                    </div>
                    <input 
                        className="form-control form-control-sm" 
                        type="text" name="flat" value={flat} 
                        onChange={({target}) => setFlat(target.value)} 
                        disabled={props.disabled}
                    />
                </div>
            </div>
            </>
        }
        {
            needStructure &&
            <>
            <div className="col-auto col-lg-2 col-sm-4 py-2">
                <div className="input-group input-group-sm">
                    <div className="input-group-prepend">
                        <div className="input-group-text">{__('property.room')}</div>
                    </div>
                    <input 
                        className="form-control form-control-sm" 
                        type="text" name="room" value={room} 
                        onChange={({target}) => setRoom(target.value)} 
                        disabled={props.disabled}
                    />
                </div>
            </div>
            
            <div className="col-auto col-lg-4 col-sm-8 py-2">
                <div className="input-group input-group-sm">
                    <div className="input-group-prepend">
                        <div className="input-group-text">{__('property.gross_size')}</div>
                    </div>
                    <input 
                        className="form-control form-control-sm" 
                        type="text" name="gross_size_fm" value={grossSizeFm} 
                        onChange={({target}) => setGrossSizeFm(target.value)} 
                        disabled={props.disabled}
                    />
                    
                    <div className="input-group-prepend input-group-append">
                        <div className="input-group-text">{__('form.to')}</div>
                    </div>
                    <input 
                        className="form-control form-control-sm" 
                        type="text" name="gross_size_to" value={grossSizeTo} 
                        onChange={({target}) => setGrossSizeTo(target.value)} 
                        disabled={props.disabled}
                    />
                </div>
            </div>
            </>
        }
        </div>
    }
    </>)
}

const fields = ['area', 'district', 'estate_type', 'estate', 'full_address', 'structure'];

PropertyFields.propTypes = {
    fields: PropTypes.arrayOf(PropTypes.oneOf(fields)),
    reset: PropTypes.number,
    names: PropTypes.object,
    disabled: PropTypes.bool
}

PropertyFields.defaultProps = {
    'reset': 0,
    'fields': fields,

    'area': "",
    'district': "",
    'estateType': "",
    'estates': [],
    'block': '',
    'floor': '',
    'flat': '',
    'room': '',
    'grossSizeFm': '',
    'grossSizeTo': '',
    'names': {
        'estateType': 'estate_type_id',
        'area': 'area_id',
        'district': 'district_id',
        'estate': 'estate_id[]',
    },
    disabled: false,
}

export default PropertyFields;

document.querySelectorAll("property-fields").forEach(dom => {
    let props = Object.assign({}, dom.dataset);
    if(props.fields) props.fields = JSON.parse(props.fields);
    if(props.estates) props.estates = JSON.parse(props.estates);

    ['area', 'district', 'estateType', 'estate'].forEach(field => {
        if(!!props[field]) props[field] = parseInt(props[field]);
    });

    // console.log("props", props);
    ReactDOM.render(<PropertyFields {...props} />, dom);
});