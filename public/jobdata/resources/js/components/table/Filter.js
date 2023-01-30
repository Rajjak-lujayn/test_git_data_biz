import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Link } from 'react-router-dom';
import { Url, PubliUrl } from "../../Config";
import logo from '../../../images/bizprospex_logo.png';
import Autocomplete from '@mui/material/Autocomplete';
import TextField from '@mui/material/TextField';
import Stack from '@mui/material/Stack';
import { FormControl, InputLabel, MenuItem, Select } from '@mui/material';

const JobTitle = ({ props }) => {

  const [allOptions, setallOptions] = useState([]);
  const [optionPara, setoptionPara] = useState(null);
  const [fieldVal, setFieldVal] = useState([]);

  useEffect(() => {
    setFieldVal([]);
  }, [props.clearFilterClicked]);

  useEffect(() => {
    optionPara && axios.post(`${PubliUrl}/api/sendOptions/`, null, {
      params: { option: optionPara, filterName: "job_title" }
    }).then(res => {
      setallOptions(res.data.job_title);
    });
  }, [optionPara]);


  return (
    <div className="field">
      <Stack spacing={1} sx={{ width: "100%" }}>
        <Autocomplete
          multiple
          // disableCloseOnSelect
          freeSolo
          limitTags={1}
          id="searchByJobTitle"
          value={fieldVal}
          options={allOptions}
          isOptionEqualToValue={(option, value) => option.job_title === value.job_title}
          size="small"
          getOptionLabel={(option) => option.job_title}
          onChange={(e, newValue) => {
            props.filterChanged(e, "searchByJobTitle", newValue)
            setFieldVal(newValue);
          }}
          renderInput={(params) => (
            <TextField
              {...params}
              label="Job Title"
              placeholder="Type 2 charactor"
              onChange={(e) => {
                (e.target.value.length > 1 || e.target.value.length == 0) && setoptionPara(e.target.value);
              }}
            />
          )}
        />
      </Stack>
    </div>
  );
}

const Company = ({ props }) => {

  const [allOptions, setallOptions] = useState([]);
  const [optionPara, setoptionPara] = useState(null);
  const [fieldVal, setFieldVal] = useState([]);

  useEffect(() => {
    setFieldVal([]);
  }, [props.clearFilterClicked]);

  useEffect(() => {
    optionPara && axios.post(`${PubliUrl}/api/sendOptions/`, null, {
      params: { option: optionPara, filterName: "company" }
    }).then(res => {
      setallOptions(res.data.company);
    });
  }, [optionPara]);

  return (
    <div className="field">

      <Stack spacing={1} sx={{ width: "100%" }}>
        <Autocomplete
          multiple
          // disableCloseOnSelect
          freeSolo
          limitTags={1}
          id="searchByCompany"
          value={fieldVal}
          options={allOptions}
          isOptionEqualToValue={(option, value) => option.company === value.company}
          size="small"
          getOptionLabel={(option) => option.company}
          onChange={(e, newValue) => {
            props.filterChanged(e, "searchByCompany", newValue)
            setFieldVal(newValue);
          }}
          renderInput={(params) => (
            <TextField
              {...params}
              label="Company"
              placeholder="Type 2 charactor"
              onChange={(e) => {
                (e.target.value.length > 1 || e.target.value.length == 0) && setoptionPara(e.target.value);
              }}
            />
          )}
        />
      </Stack>
    </div>
  );
}

const Industry = ({ props }) => {

  const [allOptions, setallOptions] = useState([]);
  const [optionPara, setoptionPara] = useState(null);
  const [fieldVal, setFieldVal] = useState([]);

  useEffect(() => {
    setFieldVal([]);
  }, [props.clearFilterClicked]);

  useEffect(() => {
    axios.post(`${PubliUrl}/api/sendOptions/`, null, {
      params: { filterName: "industry" }
    }).then(res => {
      setallOptions(res.data.industry);
    });
  }, []);

  useEffect(() => {
    optionPara && axios.post(`${PubliUrl}/api/sendOptions/`, null, {
      params: { option: optionPara, filterName: "industry" }
    }).then(res => {
      setallOptions(res.data.industry);
    });
  }, [optionPara]);

  return (
    <div className="field">
      <Stack spacing={1} sx={{ width: "100%" }}>
        <Autocomplete
          multiple
          // disableCloseOnSelect
          freeSolo
          limitTags={1}
          // id="filterByIndustry"
          value={fieldVal}
          options={allOptions}
          isOptionEqualToValue={(option, value) => option.industry === value.industry}
          size="small"
          getOptionLabel={(option) => option.industry}
          onChange={(e, newValue) => {
            props.filterChanged(e, "filterByIndustry", newValue)
            setFieldVal(newValue);
          }}
          renderInput={(params) => (
            <TextField
              {...params}
              label="Industry"
              placeholder="Type 2 charactor"
            />
          )}
        />
      </Stack>
    </div>
  );
}
const State = ({ props }) => {

  const [allOptions, setallOptions] = useState([]);
  const [fieldVal, setFieldVal] = useState([]);

  useEffect(() => {
    axios.post(`${PubliUrl}/api/sendOptions/`, null, { params: { filterName: "state" } })
      .then(res => {
        setallOptions(res.data.state);
      });
  }, []);

  useEffect(() => {
    setFieldVal([]);
  }, [props.clearFilterClicked]);

  return (
    <div className="field">
      <Stack spacing={1} sx={{ width: "100%" }}>
        <Autocomplete
          multiple
          // disableCloseOnSelect
          freeSolo
          limitTags={1}
          // id="filterByState"
          options={allOptions}
          value={fieldVal}
          isOptionEqualToValue={(option, value) => option.state === value.state}
          size="small"
          getOptionLabel={(option) => option.state}
          onChange={(e, newValue) => {
            props.filterChanged(e, "filterByState", newValue)
            setFieldVal(newValue);
          }}
          renderInput={(params) => (
            <TextField
              {...params}
              label="State"
              placeholder="Type 2 charactor"
            />
          )}
        />
      </Stack>
    </div>
  );
}

const Level = ({ props }) => {

  // const [allOptions, setallOptions] = useState([]);
  // const [fieldVal, setFieldVal] = useState([]);

  // useEffect(() => {
  //   axios.post(`${PubliUrl}/api/sendOptions/`, null, { params: { filterName: "state" } })
  //     .then(res => {
  //       setallOptions(res.data.state);
  //     });
  // }, []);

  // useEffect(() => {
  //   setFieldVal([]);
  // }, [props.clearFilterClicked]);
  const options = [
    { label: 'Entry Level', value: 'entry-level' },
    { label: 'Mid Level', value: 'mid-level' },
    { label: 'Senior Level', value: 'senior-level'}
  ];
  return (
    <div className="field">

      <Stack spacing={1} sx={{ width: "100%" }}>
        <Autocomplete
          // disableCloseOnSelect
          freeSolo
          // limitTags={1}
          // id="filterBySalary"
          options={options}
          isOptionEqualToValue={(option, value) => option.value === value.value}
          size="small"
          getOptionLabel={(option) => option.label}
          onChange={(e, newValue) => {
            props.filterChanged(e, "filterByLevel", newValue ? newValue['value'] : null)
          }}
          renderInput={(params) => (
            <TextField
              {...params}
              label="Level"
              placeholder="Select Level"
            />
          )}
        />
      </Stack>
    </div>
  );
}

const City = ({ props }) => {

  const [allOptions, setallOptions] = useState([]);
  const [fieldVal, setFieldVal] = useState([]);

  useEffect(() => {
    axios.post(`${PubliUrl}/api/sendOptions/`, null, {
      params: { filterName: "city" }
    }).then(res => {
      setallOptions(res.data.city);
    });
  }, []);

  useEffect(() => {
    setFieldVal([]);
  }, [props.clearFilterClicked]);
  return (
    <div className="field">
      <Stack spacing={1} sx={{ width: "100%" }}>
        <Autocomplete
          multiple
          // disableCloseOnSelect
          freeSolo
          limitTags={1}
          // id="filterByCity"
          options={allOptions}
          value={fieldVal}
          isOptionEqualToValue={(option, value) => option.city === value.city}
          size="small"
          getOptionLabel={(option) => option.city}
          onChange={(e, newValue) => {
            props.filterChanged(e, "filterByCity", newValue)
            setFieldVal(newValue);
          }}
          renderInput={(params) => (
            <TextField
              {...params}
              label="City"
              placeholder="Type 2 charactor"
            />
          )}
        />
      </Stack>
    </div>
  );
}

const Salary = ({ props }) => {

  const [allOptions, setallOptions] = useState([]);

  useEffect(() => {
    axios.post(`${PubliUrl}/api/sendOptions/`, null, {
      params: {
        filterName: "salary"
      }
    }).then(res => {
      setallOptions(res.data.salary);
    });
  }, []);


  return (
    <div className="field">
      <Stack spacing={1} sx={{ width: "100%" }}>
        <Autocomplete
          // disableCloseOnSelect
          freeSolo
          limitTags={1}
          id="filterBySalary"
          options={allOptions}
          isOptionEqualToValue={(option, value) => option.salary === value.salary}
          size="small"
          getOptionLabel={(option) => option.salary}
          onChange={(e, newValue) => {
            props.filterChanged(e, "filterBySalary", newValue)
          }}
          renderInput={(params) => (
            <TextField
              {...params}
              label="Salary"
              placeholder="Type 2 charactor"
            />
          )}
        />
      </Stack>
    </div>
  );
}

const Remote = ({ props }) => {

  const [remoteClick, setRemoteClick] = useState(null);

  return (
    <div className="field">
      <div className="remote-wrap">
        <label>Remote</label>
        <div className='checkbox_wrap'>
          <label htmlFor="filterByRemoteYes">
            <input
              type="radio"
              name='filterByRemote'
              id="filterByRemoteYes"
              onClick={(e) => {
                console.log(e);
                if (remoteClick == "yes") {
                  e.target.checked = false;
                  setRemoteClick(null);
                  props.filterChanged(e, "filterByRemoteYes", "");
                };
              }}
              onChange={(e) => {
                setRemoteClick("yes");
                props.filterChanged(e, "filterByRemoteYes", "Remote");
              }}
            /><span className='radiotbtn'></span>
            Yes</label>
          <label htmlFor="filterByRemoteNo">
            <input
              type="radio"
              name='filterByRemote'
              id="filterByRemoteNo"
              onClick={(e) => {
                if (remoteClick == "no") {
                  e.target.checked = false;
                  setRemoteClick(null);
                  props.filterChanged(e, "filterByRemoteYes", "");
                };
              }}
              onChange={(e) => {
                setRemoteClick("no");
                props.filterChanged(e, "filterByRemoteYes", "no");
              }}
            />
            <span className='radiotbtn'></span>
            No</label>
        </div>
      </div>
    </div>
  );
}

const FilterForm = ({ props }) => {
  return (
    <div id="left-sidebar">
      <div className="top_bar">
        <div className='contact-us_wrap'>
          <div className='email'>
            <a href="emailto:murtaza@bizprospex.com">
              <i className="fa-solid fa-envelope"></i> murtaza@bizprospex.com
            </a>
          </div>

          <ul className="social_item">
            <li>
              <a href="#"><i className="fa-brands fa-facebook-f"></i></a>
            </li>
            <li>
              <a href="#"><i className="fa-brands fa-twitter"></i></a>
            </li>
            <li>
              <a href="#"><i className="fa-brands fa-linkedin-in"></i></a>
            </li>
          </ul>
        </div>

      </div>
      <div className="body_part-content">
        <div className="brand_wrap">
          <Link className='bizprospex_logo' to="/">
            <img src={`${PubliUrl}/images/bizprospex_logo.png`} alt="logo"></img>
          </Link>
        </div>
        <div className="filter_section" onSubmit={e => e.preventDefault()}>
          <div className="filter_wrapper">
            <div className="container-fluid">
              <JobTitle props={props} />
              <Company props={props} />
              <Industry props={props} />
              <State props={props} />
              {/* <City props={props} /> */}
              <Level props={props} />
              <Salary props={props} />
              <Remote props={props} />
            </div>
          </div>
        </div>
      </div>
      <div className="copyright_content">
        <p>© 2022 bizb2b. all rights Reserved. powered by bizb2b</p>
      </div>
    </div>
  );
}

export default FilterForm