const billingMetrics = [
  { label: 'Monthly Revenue', value: '$48,250', trend: '+18.2%' },
  { label: 'Outstanding', value: '$8,120', trend: '-4.1%' },
  { label: 'Collected', value: '$32,970', trend: '+12.5%' },
  { label: 'Treatment Plans', value: '27', trend: '+6.7%' }
];

const dentalRows = [
  { tooth: '18', condition: 'Cavity', status: 'Needs treatment' },
  { tooth: '24', condition: 'Healthy', status: 'Routine check' },
  { tooth: '31', condition: 'Restoration', status: 'Monitoring' },
  { tooth: '46', condition: 'Root canal', status: 'Follow-up' }
];

export default function App() {
  return (
    <div className="min-h-screen bg-slate-50 text-slate-800">
      <aside className="fixed inset-y-0 left-0 w-72 bg-slate-900 text-slate-100 p-6">
        <div className="mb-10 text-2xl font-bold">ClinicAI Pro</div>
        <nav className="space-y-2">
          <div className="rounded-lg bg-slate-800 px-3 py-2">Dashboard</div>
          <div className="rounded-lg px-3 py-2 text-slate-300">Patients</div>
          <div className="rounded-lg px-3 py-2 text-slate-300">Appointments</div>
          <div className="rounded-lg px-3 py-2 text-slate-300">Medical Records</div>
          <div className="rounded-lg px-3 py-2 text-slate-300">Dental</div>
          <div className="rounded-lg px-3 py-2 text-slate-300">Billing</div>
          <div className="rounded-lg px-3 py-2 text-slate-300">AI Assistant</div>
        </nav>
      </aside>

      <main className="ml-72 p-8">
        <header className="mb-8 flex items-center justify-between">
          <div>
            <p className="text-sm uppercase tracking-wide text-sky-700">Operations</p>
            <h1 className="text-3xl font-bold">Healthcare Performance Dashboard</h1>
          </div>
          <button className="rounded-lg bg-sky-600 px-4 py-2 font-medium text-white shadow hover:bg-sky-500">
            Schedule Visit
          </button>
        </header>

        <section className="grid gap-4 md:grid-cols-4">
          {billingMetrics.map((item) => (
            <div key={item.label} className="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
              <p className="text-sm text-slate-500">{item.label}</p>
              <p className="mt-3 text-3xl font-bold text-slate-900">{item.value}</p>
              <p className="mt-1 text-sm text-emerald-600">{item.trend}</p>
            </div>
          ))}
        </section>

        <section className="mt-8 grid gap-6 lg:grid-cols-2">
          <div className="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 className="mb-4 text-xl font-semibold">Dental Chart Overview</h2>
            <div className="overflow-hidden rounded-xl border border-slate-200">
              <table className="min-w-full text-left text-sm">
                <thead className="bg-slate-100">
                  <tr>
                    <th className="px-4 py-3 font-medium">Tooth</th>
                    <th className="px-4 py-3 font-medium">Condition</th>
                    <th className="px-4 py-3 font-medium">Status</th>
                  </tr>
                </thead>
                <tbody>
                  {dentalRows.map((row) => (
                    <tr key={row.tooth} className="border-t border-slate-200">
                      <td className="px-4 py-3">{row.tooth}</td>
                      <td className="px-4 py-3">{row.condition}</td>
                      <td className="px-4 py-3">
                        <span className="rounded-full bg-amber-100 px-2 py-1 text-amber-700">{row.status}</span>
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          </div>

          <div className="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 className="mb-4 text-xl font-semibold">AI Clinical Assistant</h2>
            <div className="rounded-xl bg-amber-50 p-4 text-sm text-amber-900">
              AI Generated Assistance - Requires Professional Review
            </div>
            <ul className="mt-4 space-y-2 text-sm text-slate-600">
              <li>• Summarize patient progress and treatment history</li>
              <li>• Draft care pathway and follow-up suggestions</li>
              <li>• Highlight pending procedures and reminders</li>
            </ul>
          </div>
        </section>
      </main>
    </div>
  );
}
