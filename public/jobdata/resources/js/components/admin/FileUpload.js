import React, { useState, useEffect } from 'react'
import Loader from "react-js-loader";
// import Header from './Header'
import Papa from "papaparse";
import { Url, PubliUrl } from "../../Config"

const UploadFile = () => {
  const [dataForImport, setDataForImport] = useState(null);
  const [csvFileNotice, setCsvFileNotice] = useState(null);

  useEffect(async () => {
    dataForImport ?
      axios.post(`${PubliUrl}/api/importData`, { jsonRecords: dataForImport }).then(res => {
        // alert("Data Imported Successfully");
        setCsvFileNotice("success");
      })
      : ''
  }, [dataForImport]);

  // csvFileNotice != null ? setInterval(() => {
  //   setCsvFileNotice(null);
  // }, 5000) : '';

  return (
    <>
      <div className='bizpros-form-section'>
        <div className='container'>
          <div className='form_wrapper'>
            <h3>Upload .csv File Here</h3>
            <div className="App">
              <input
                type="file"
                accept=".csv"
                onChange={(e) => {
                  const files = e.target.files;
                  console.log(files);
                  if (files) {
                    setCsvFileNotice("processing");
                    console.log(files[0]);
                    Papa.parse(files[0], {
                      complete: function (results) {
                        setDataForImport(results.data)
                        console.log("Finished:", results.data);
                      }
                    }
                    )
                  }
                }}
              />
              {csvFileNotice == "processing" ? <span>Please Wait Your CSV in uploading...</span> : csvFileNotice == "success" ? <span>Data Imported Successfully...</span> : ''}
            </div>
          </div>
        </div>
      </div>
    </>
  )

}

const AdminHome = () => {
  const [isAdmin, is_admin] = useState(false);

  useEffect(async () => {
    axios.get(`${PubliUrl}/api/isAdmin`).then(res => {
      is_admin(res.data.isAdmin);
    });
  }, [''])

  if (isAdmin) {
    return (
      <>
        <UploadFile />
      </>
    )
  } else {
    return (
      <Loader
        type="spinner-circle"
        bgColor={"#111"}
        title={"box-rotate-x"}
        color={'#FFFFFF'}
        size={100}
      />)
  }
}

export default AdminHome