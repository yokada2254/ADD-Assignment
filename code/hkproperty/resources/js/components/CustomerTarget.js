import React, { useState, useEffect, useMemo } from 'react';
import ReactDOM from 'react-dom';

function CustomerTarget({areas_districts, estate_types}){
    const [area, setArea] = useState(undefined);
    const [district, setDistrict] = useState(undefined);
    const [estateType, setEstateType] = useState(undefined);

    const [keyword, setKeyword] = useState("");
    const [estateList, setEstateList] = useState([]);

    const selectedArea = useMemo(() => areas_districts.filter(item => item.id == parseInt(area)).pop(), [area])
    const selectedDistrict = useMemo(() => selectedArea?.districts.filter(item => item.id == parseInt(district)).pop(), [district])

    useEffect(() => {
        if(!area) setDistrict(undefined);
    }, [area, district])

    useEffect(() => {
        if(!!keyword){
            getEstates()
        }else{
            setEstateList([]);
        }
    }, [keyword])
    
    const getEstates = () => {
        let params = new URLSearchParams();
        params.set("area", area);
        params.set("district", district);
        params.set("estateType", estateType);
        params.set("keyword", keyword);

        fetch(`/property/estates?${params.toString()}`, {method: "GET"})
            .then(res => res.json())
            .then(res => {
                console.log("getEstates", res);
            });
    }

    return (
    <div className="row">
        <div className="form-group">
            <select name="area_id" onChange={({target}) => setArea(target.value)} value={area}>
                <option value="">Select</option>
            {
                areas_districts.map(item => (
                <option value={item.id} key={`area_${item.id}`}>{item.name}</option>))
            }
            </select>

            <select name="district_id" onChange={({target}) => setDistrict(target.value)} value={district}>
                <option value="">Select</option>
            {
                selectedArea?.districts.map(item => (
                <option value={item.id} key={`district_${item.id}`}>{item.name}</option>))
            }
            </select>

            <select name="estate_type_id" onChange={({target}) => setEstateType(target.value)} value={estateType}>
                <option value="">Select</option>
            {
                estate_types.map(item => (
                <option value={item.id} key={`estate_type_${item.id}`}>{item.name}</option>))
            }
            </select>

            <input type="text" value={keyword} onChange={({target}) => setKeyword(target.value)} />
        </div>
    </div>)
}

export default CustomerTarget;

if(document.querySelectorAll("customer-target").length > 0){
    fetch("/property/options", {method: "GET"})
        .then(res => res.json())
        .then(res => {
            document.querySelectorAll("customer-target").forEach(dom => {
                let props = Object.assign({}, dom.dataset);
                ReactDOM.render(
                    <CustomerTarget 
                        {...props} 
                        estate_types={res.estate_types} 
                        areas_districts={res.areas_districts}
                />, dom);
            })
        });
}